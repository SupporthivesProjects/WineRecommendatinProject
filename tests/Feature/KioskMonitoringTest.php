<?php

namespace Tests\Feature;

use App\Models\KioskStatus;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Kiosk monitoring: heartbeat, recovery helpers and the admin dashboard actions.
 * Runs against its own in-memory SQLite database so it never touches the real one.
 */
class KioskMonitoringTest extends TestCase
{
    private const DEVICE = '0f5c2d1e-3b4a-4c5d-8e6f-7a8b9c0d1e2f';

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);
        DB::purge('sqlite');
        RateLimiter::clear('kiosk|'.self::DEVICE.'|127.0.0.1');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('user');
            $table->string('status')->default('active');
            $table->unsignedBigInteger('store_id')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('store_name')->nullable();
            // used by the admin header's notification counts
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->string('contact_status')->nullable();
            $table->string('new_contact_number')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // Tables the admin header queries for its notification badges
        foreach (['popup_enquiries', 'store_support_requests'] as $name) {
            Schema::create($name, function (Blueprint $table) {
                $table->id();
                $table->string('status')->nullable();
                $table->timestamps();
            });
        }

        Schema::create('kiosk_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('kiosk_id')->unique();
            $table->string('label', 100)->nullable();
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamp('logged_in_at')->nullable();
            $table->timestamp('logged_out_at')->nullable();
            $table->timestamps();
        });

        DB::table('stores')->insert(['id' => 1, 'store_name' => 'Wine Haven']);
    }

    private function makeUser(string $role, string $email, ?int $storeId = 1): User
    {
        return User::create([
            'first_name' => 'Kiosk',
            'last_name' => ucfirst($role),
            'email' => $email,
            'password' => 'password',
            'role' => $role,
            'status' => 'active',
            'store_id' => $storeId,
        ]);
    }

    private function beat(array $extra = [])
    {
        return $this->postJson('/kiosk/heartbeat', array_merge(['device_key' => self::DEVICE], $extra));
    }

    public function test_logged_in_heartbeat_registers_the_kiosk_for_the_users_store(): void
    {
        $user = $this->makeUser('user', 'a@example.test');

        $this->actingAs($user)->beat()
            ->assertOk()
            ->assertJson(['status' => 'active', 'kiosk_id' => '1-K-'.self::DEVICE, 'logged_in' => true]);

        $kiosk = KioskStatus::firstOrFail();
        $this->assertSame($user->id, (int) $kiosk->user_id);
        $this->assertNotNull($kiosk->logged_in_at);
        $this->assertNull($kiosk->logged_out_at);
    }

    public function test_login_time_only_changes_when_a_different_user_logs_in(): void
    {
        $first = $this->makeUser('user', 'a@example.test');
        $second = $this->makeUser('user', 'b@example.test');

        $this->travelTo(now()->subMinutes(10));
        $this->actingAs($first)->beat()->assertOk();
        $loggedInAt = KioskStatus::first()->logged_in_at;

        $this->travelBack();
        $this->actingAs($first)->beat()->assertOk();
        $this->assertTrue(KioskStatus::first()->logged_in_at->eq($loggedInAt), 'Same user: login time kept');

        $this->actingAs($second)->beat()->assertOk();
        $kiosk = KioskStatus::first();
        $this->assertSame($second->id, (int) $kiosk->user_id);
        $this->assertTrue($kiosk->logged_in_at->gt($loggedInAt), 'New user: login time updated');
    }

    public function test_guest_heartbeat_marks_the_kiosk_logged_out_but_online(): void
    {
        $this->actingAs($this->makeUser('user', 'a@example.test'))->beat()->assertOk();
        auth()->logout();

        $this->beat(['kiosk_id' => '1-K-'.self::DEVICE])
            ->assertOk()
            ->assertJson(['status' => 'active', 'logged_in' => false]);

        $kiosk = KioskStatus::first();
        $this->assertNull($kiosk->user_id);
        $this->assertNotNull($kiosk->logged_out_at);
        $this->assertTrue($kiosk->last_seen_at->gt(now()->subMinute()));
    }

    public function test_guest_cannot_update_a_kiosk_with_another_devices_key(): void
    {
        $this->actingAs($this->makeUser('user', 'a@example.test'))->beat()->assertOk();
        auth()->logout();

        $this->postJson('/kiosk/heartbeat', [
            'device_key' => 'aaaaaaaa-bbbb-4ccc-8ddd-eeeeeeeeeeee',
            'kiosk_id' => '1-K-'.self::DEVICE,
        ])->assertOk()->assertJson(['status' => 'unregistered_guest']);

        $this->assertNotNull(KioskStatus::first()->user_id, 'Logged-in state must not change');
    }

    public function test_first_heartbeat_from_two_tabs_at_once_does_not_fail(): void
    {
        $user = $this->makeUser('user', 'a@example.test');

        // Simulate the other tab inserting the same kiosk between our lookup and our insert
        $raced = false;
        KioskStatus::creating(function (KioskStatus $kiosk) use (&$raced) {
            if (!$raced) {
                $raced = true;
                DB::table('kiosk_statuses')->insert([
                    'kiosk_id' => $kiosk->kiosk_id, 'store_id' => $kiosk->store_id, 'user_id' => $kiosk->user_id,
                    'last_seen_at' => now(), 'logged_in_at' => now(), 'created_at' => now(), 'updated_at' => now(),
                ]);
            }
        });

        $this->actingAs($user)->beat()->assertOk()->assertJson(['status' => 'active']);
        $this->assertTrue($raced);
        $this->assertSame(1, KioskStatus::count());
    }

    public function test_heartbeat_is_rate_limited_per_device(): void
    {
        $this->actingAs($this->makeUser('user', 'a@example.test'));

        for ($i = 0; $i < 30; $i++) {
            $this->beat()->assertOk();
        }
        $this->beat()->assertStatus(429);

        // A different kiosk behind the same IP is not affected
        $this->postJson('/kiosk/heartbeat', ['device_key' => 'aaaaaaaa-bbbb-4ccc-8ddd-eeeeeeeeeeee'])->assertOk();
    }

    public function test_token_endpoint_returns_the_current_session_token(): void
    {
        $response = $this->getJson('/kiosk/token')->assertOk();

        $this->assertSame(session()->token(), $response->json('token'));
    }

    public function test_admin_can_name_a_kiosk_and_users_cannot(): void
    {
        $kiosk = KioskStatus::create(['kiosk_id' => '1-K-'.self::DEVICE, 'store_id' => 1, 'last_seen_at' => now()]);

        $this->actingAs($this->makeUser('user', 'u@example.test'))
            ->patchJson("/admin/admin-kiosks/{$kiosk->id}/label", ['label' => 'Hacked'])
            ->assertRedirect(route('home'));
        $this->assertNull($kiosk->fresh()->label);

        $admin = $this->makeUser('admin', 'admin@example.test', null);
        $this->actingAs($admin)
            ->patchJson("/admin/admin-kiosks/{$kiosk->id}/label", ['label' => '  Entrance tablet  '])
            ->assertOk()->assertJson(['label' => 'Entrance tablet']);
        $this->assertSame('Entrance tablet', $kiosk->fresh()->label);

        $this->actingAs($admin)
            ->patchJson("/admin/admin-kiosks/{$kiosk->id}/label", ['label' => str_repeat('x', 101)])
            ->assertStatus(422);

        $this->actingAs($admin)
            ->patchJson("/admin/admin-kiosks/{$kiosk->id}/label", ['label' => ''])
            ->assertOk();
        $this->assertNull($kiosk->fresh()->label);
    }

    public function test_only_stale_kiosks_can_be_removed(): void
    {
        $admin = $this->makeUser('admin', 'admin@example.test', null);
        $recent = KioskStatus::create(['kiosk_id' => '1-K-recent', 'store_id' => 1, 'last_seen_at' => now()->subDays(2)]);
        $stale = KioskStatus::create(['kiosk_id' => '1-K-stale', 'store_id' => 1, 'last_seen_at' => now()->subDays(8)]);

        $this->actingAs($admin)->deleteJson("/admin/admin-kiosks/{$recent->id}")->assertStatus(422);
        $this->assertNotNull($recent->fresh());

        $this->actingAs($this->makeUser('user', 'u@example.test'))
            ->deleteJson("/admin/admin-kiosks/{$stale->id}")->assertRedirect(route('home'));
        $this->assertNotNull($stale->fresh());

        $this->actingAs($admin)->deleteJson("/admin/admin-kiosks/{$stale->id}")->assertOk();
        $this->assertNull($stale->fresh());
    }

    public function test_dashboard_shows_names_and_does_not_claim_offline_kiosks_are_logged_in(): void
    {
        $user = $this->makeUser('user', 'shop@example.test');
        KioskStatus::create(['kiosk_id' => '1-K-online', 'label' => 'Entrance tablet', 'store_id' => 1, 'user_id' => $user->id, 'last_seen_at' => now()]);
        KioskStatus::create(['kiosk_id' => '1-K-offline', 'store_id' => 1, 'user_id' => $user->id, 'last_seen_at' => now()->subHour()]);
        KioskStatus::create(['kiosk_id' => '1-K-stale', 'store_id' => 1, 'last_seen_at' => now()->subDays(9)]);

        $html = $this->actingAs($this->makeUser('admin', 'admin@example.test', null))
            ->get('/admin/admin-kiosks')
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('Entrance tablet', $html);
        $this->assertStringContainsString('Kiosk User', $html, 'Recorded user shows first + last name');
        $this->assertSame(1, substr_count($html, '>Logged In<'), 'Only the online kiosk is shown as logged in');
        $this->assertStringContainsString('Last user (offline)', $html);
        $this->assertSame(1, substr_count($html, 'kiosk-remove"'), 'Remove is offered only for the stale kiosk');
        $this->assertStringContainsString('>Stale<', $html);
    }
}
