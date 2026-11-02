<?php

namespace Tests\Feature;

use App\Models\KioskRemoteLogin;
use App\Models\KioskStatus;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Remote kiosk login: only the main administrator, only accounts with role exactly
 * "user" of the kiosk's own store, explicit username confirmation, one-time and
 * short-lived requests, and the kiosk must prove its identity with its device key.
 */
class KioskRemoteLoginTest extends TestCase
{
    private const DEVICE = '0f5c2d1e-3b4a-4c5d-8e6f-7a8b9c0d1e2f';
    private const OTHER_DEVICE = 'aaaaaaaa-bbbb-4ccc-8ddd-eeeeeeeeeeee';

    private User $admin;
    private User $storeUser;
    private KioskStatus $kiosk;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);
        DB::purge('sqlite');
        foreach ([self::DEVICE, self::OTHER_DEVICE] as $device) {
            RateLimiter::clear('kiosk|'.$device.'|127.0.0.1');
        }

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('user');
            $table->string('status')->default('active');
            $table->unsignedBigInteger('store_id')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('previous_login_at')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('store_name')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

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

        (require database_path('migrations/2026_11_02_100000_create_kiosk_remote_logins_table.php'))->up();

        DB::table('stores')->insert([
            ['id' => 1, 'store_name' => 'Wine Haven'],
            ['id' => 2, 'store_name' => 'Cellar Two'],
        ]);

        $this->admin = $this->makeUser('admin', 'admin@example.test', null);
        $this->storeUser = $this->makeUser('user', 'kiosk1@example.test', 1);

        // A logged-out kiosk of store 1 that reported just now
        $this->kiosk = KioskStatus::create([
            'kiosk_id' => '1-K-'.self::DEVICE,
            'store_id' => 1,
            'user_id' => null,
            'last_seen_at' => now(),
        ]);
    }

    private function makeUser(string $role, string $email, ?int $storeId): User
    {
        return User::create([
            'first_name' => 'Test',
            'last_name' => ucfirst($role),
            'email' => $email,
            'password' => 'password',
            'role' => $role,
            'status' => 'active',
            'store_id' => $storeId,
        ]);
    }

    private function approve(User $target, array $overrides = [], ?User $as = null)
    {
        return $this->actingAs($as ?? $this->admin)->postJson(
            route('admin.kiosks.remote-login.store', $this->kiosk),
            array_merge([
                'user_id' => $target->id,
                'approved_username' => $target->email,
                'confirm_username' => $target->email,
                'approved_role' => $target->role,
            ], $overrides)
        );
    }

    /** Logged-out heartbeat from a kiosk browser; returns the remote_login payload, if any. */
    private function guestBeat(string $device = self::DEVICE, ?string $kioskId = null): ?array
    {
        Auth::logout();
        $this->app['session']->flush();

        return $this->postJson('/kiosk/heartbeat', [
            'device_key' => $device,
            'kiosk_id' => $kioskId ?? '1-K-'.$device,
        ])->assertOk()->json('remote_login');
    }

    private function complete(array $delivery, string $device = self::DEVICE, ?string $kioskId = null)
    {
        return $this->postJson('/kiosk/remote-login', [
            'request_id' => $delivery['id'],
            'token' => $delivery['token'],
            'device_key' => $device,
            'kiosk_id' => $kioskId ?? '1-K-'.self::DEVICE,
        ]);
    }

    public function test_correct_store_user_is_signed_in_after_explicit_approval(): void
    {
        $this->approve($this->storeUser)->assertCreated()->assertJsonPath('request.status', 'pending');

        $delivery = $this->guestBeat();
        $this->assertNotNull($delivery);
        $this->assertSame('delivered', KioskRemoteLogin::first()->status);

        $this->complete($delivery)->assertOk()->assertJson(['success' => true, 'redirect' => route('user.dashboard')]);
        $this->assertAuthenticatedAs($this->storeUser);

        $request = KioskRemoteLogin::first();
        $this->assertSame('completed', $request->status);
        $this->assertSame($this->admin->id, (int) $request->requested_by);
        $this->assertSame('kiosk1@example.test', $request->approved_username);
        $this->assertSame('user', $request->verified_role);
        $this->assertNotNull($request->completed_at);
        $this->assertNull($request->token_hash, 'Token is cleared once used');
    }

    public function test_admin_sub_admin_and_store_manager_accounts_are_rejected(): void
    {
        foreach (['admin' => 'other-admin', 'sub_admin' => 'sub', 'store_manager' => 'manager'] as $role => $name) {
            $target = $this->makeUser($role, $name.'@example.test', 1);

            $this->approve($target)->assertForbidden();
        }

        $this->assertSame(0, KioskRemoteLogin::where('status', 'pending')->count());
        $this->assertSame(3, KioskRemoteLogin::where('status', 'rejected')->count(), 'Rejected attempts are audited');
        $this->assertNull($this->guestBeat());
    }

    public function test_a_role_claimed_as_user_is_still_checked_against_the_database(): void
    {
        $manager = $this->makeUser('store_manager', 'manager@example.test', 1);

        $this->approve($manager, ['approved_role' => 'user'])->assertForbidden();
        $this->assertNull($this->guestBeat());
    }

    public function test_user_of_another_store_is_rejected(): void
    {
        $otherStoreUser = $this->makeUser('user', 'kiosk2@example.test', 2);

        $this->approve($otherStoreUser)->assertForbidden();
        $this->assertNull($this->guestBeat());
    }

    public function test_wrong_typed_username_is_rejected(): void
    {
        $this->approve($this->storeUser, ['confirm_username' => 'kiosk1@example.tes'])->assertStatus(422);

        $this->assertSame(0, KioskRemoteLogin::where('status', 'pending')->count());
        $this->assertNull($this->guestBeat());
    }

    public function test_missing_confirmation_creates_no_request(): void
    {
        $this->actingAs($this->admin)->postJson(route('admin.kiosks.remote-login.store', $this->kiosk), [
            'user_id' => $this->storeUser->id,
            'approved_username' => $this->storeUser->email,
            'approved_role' => 'user',
        ])->assertStatus(422);

        $this->assertSame(0, KioskRemoteLogin::count());
    }

    public function test_username_changed_after_it_was_shown_is_rejected(): void
    {
        $shown = $this->storeUser->email;
        $this->storeUser->update(['email' => 'renamed@example.test']);

        $this->approve($this->storeUser, ['approved_username' => $shown, 'confirm_username' => $shown])->assertStatus(422);
        $this->assertNull($this->guestBeat());
    }

    public function test_username_changed_after_approval_fails_on_the_kiosk(): void
    {
        $this->approve($this->storeUser)->assertCreated();
        $delivery = $this->guestBeat();

        $this->storeUser->update(['email' => 'renamed@example.test']);

        $this->complete($delivery)->assertForbidden();
        $this->assertGuest();
        $this->assertSame('failed', KioskRemoteLogin::first()->status);
    }

    public function test_role_changed_after_approval_fails_on_the_kiosk(): void
    {
        $this->approve($this->storeUser)->assertCreated();
        $delivery = $this->guestBeat();

        $this->storeUser->update(['role' => 'store_manager']);

        $this->complete($delivery)->assertForbidden();
        $this->assertGuest();
        $request = KioskRemoteLogin::first();
        $this->assertSame('failed', $request->status);
        $this->assertStringContainsString('store_manager', $request->failure_reason);
    }

    public function test_user_moved_to_another_store_after_approval_fails(): void
    {
        $this->approve($this->storeUser)->assertCreated();
        $delivery = $this->guestBeat();

        $this->storeUser->update(['store_id' => 2]);

        $this->complete($delivery)->assertForbidden();
        $this->assertGuest();
    }

    public function test_expired_request_is_not_delivered_or_accepted(): void
    {
        $this->approve($this->storeUser)->assertCreated();
        $delivery = $this->guestBeat();

        $this->travel(KioskRemoteLogin::EXPIRY_MINUTES + 1)->minutes();

        $this->complete($delivery)->assertStatus(410);
        $this->assertGuest();
        $this->assertSame('expired', KioskRemoteLogin::first()->status);
        $this->assertNull($this->guestBeat());
    }

    public function test_used_request_cannot_be_replayed(): void
    {
        $this->approve($this->storeUser)->assertCreated();
        $delivery = $this->guestBeat();
        $this->complete($delivery)->assertOk();

        Auth::logout();
        $this->app['session']->flush();

        $this->complete($delivery)->assertStatus(410);
        $this->assertGuest();
    }

    public function test_another_device_cannot_use_the_token(): void
    {
        $this->approve($this->storeUser)->assertCreated();
        $delivery = $this->guestBeat();

        $this->complete($delivery, self::OTHER_DEVICE)->assertForbidden();
        $this->assertGuest();
        $this->assertSame('failed', KioskRemoteLogin::first()->status);
        $this->assertSame('Kiosk identity mismatch.', KioskRemoteLogin::first()->failure_reason);
    }

    public function test_other_kiosks_never_receive_the_request(): void
    {
        KioskStatus::create(['kiosk_id' => '2-K-'.self::OTHER_DEVICE, 'store_id' => 2, 'last_seen_at' => now()]);
        $this->approve($this->storeUser)->assertCreated();

        // Another store's kiosk, and a device presenting this kiosk's id without its key
        $this->assertNull($this->guestBeat(self::OTHER_DEVICE, '2-K-'.self::OTHER_DEVICE));
        $this->assertNull($this->guestBeat(self::OTHER_DEVICE, '1-K-'.self::DEVICE));
        $this->assertSame('pending', KioskRemoteLogin::first()->status);
    }

    public function test_wrong_token_does_not_use_up_the_request(): void
    {
        $this->approve($this->storeUser)->assertCreated();
        $delivery = $this->guestBeat();

        $this->complete(['id' => $delivery['id'], 'token' => str_repeat('x', 64)])->assertForbidden();
        $this->assertSame('delivered', KioskRemoteLogin::first()->status);

        $this->complete($delivery)->assertOk();
        $this->assertAuthenticatedAs($this->storeUser);
    }

    public function test_kiosk_reconnecting_gets_a_fresh_token_and_the_old_one_stops_working(): void
    {
        $this->approve($this->storeUser)->assertCreated();
        $lost = $this->guestBeat();      // response lost on the way (network failure)
        $fresh = $this->guestBeat();     // next heartbeat after reconnecting

        $this->assertNotSame($lost['token'], $fresh['token']);
        $this->complete($lost)->assertForbidden();
        $this->complete($fresh)->assertOk();
        $this->assertAuthenticatedAs($this->storeUser);
    }

    public function test_sub_admin_and_store_manager_cannot_use_remote_login(): void
    {
        $subAdmin = $this->makeUser('sub_admin', 'sub@example.test', null);
        $this->actingAs($subAdmin)->getJson(route('admin.kiosks.remote-login.show', $this->kiosk))->assertForbidden();
        $this->approve($this->storeUser, [], $subAdmin)->assertForbidden();

        $manager = $this->makeUser('store_manager', 'manager@example.test', 1);
        $this->approve($this->storeUser, [], $manager)->assertRedirect();

        $this->assertSame(0, KioskRemoteLogin::count());
    }

    public function test_offline_kiosk_is_refused(): void
    {
        $this->kiosk->update(['last_seen_at' => now()->subMinutes(10)]);

        $this->approve($this->storeUser)->assertStatus(422)->assertJsonPath('success', false);
        $this->assertSame('rejected', KioskRemoteLogin::first()->status);
    }

    public function test_kiosk_with_a_user_already_signed_in_is_refused(): void
    {
        $this->kiosk->update(['user_id' => $this->storeUser->id]);
        $this->approve($this->storeUser)->assertStatus(422)->assertJsonPath('message', 'This user is already signed in on the kiosk.');

        $other = $this->makeUser('user', 'kiosk1b@example.test', 1);
        $this->kiosk->update(['user_id' => $other->id]);
        $this->approve($this->storeUser)->assertStatus(422);

        $this->assertSame(0, KioskRemoteLogin::whereIn('status', ['pending', 'delivered'])->count());
    }

    public function test_signed_in_browser_cannot_complete_a_request(): void
    {
        $this->approve($this->storeUser)->assertCreated();
        $delivery = $this->guestBeat();

        $other = $this->makeUser('user', 'kiosk1b@example.test', 1);
        $this->actingAs($other);

        $this->complete($delivery)->assertStatus(409);
        $this->assertAuthenticatedAs($other);
        $this->assertSame('failed', KioskRemoteLogin::first()->status);
    }

    public function test_candidates_list_only_active_users_of_the_kiosks_store(): void
    {
        $this->makeUser('store_manager', 'manager@example.test', 1);
        $this->makeUser('user', 'kiosk2@example.test', 2);
        $inactive = $this->makeUser('user', 'inactive@example.test', 1);
        $inactive->update(['status' => 'inactive']);

        $response = $this->actingAs($this->admin)->getJson(route('admin.kiosks.remote-login.show', $this->kiosk))->assertOk();

        $this->assertSame(['kiosk1@example.test'], array_column($response->json('eligible_users'), 'username'));
        $this->assertSame('Wine Haven', $response->json('kiosk.store_name'));
        $this->assertTrue($response->json('kiosk.online'));
    }

    public function test_status_endpoint_reports_expiry(): void
    {
        $id = $this->approve($this->storeUser)->json('request.id');

        $this->travel(KioskRemoteLogin::EXPIRY_MINUTES + 1)->minutes();

        $this->actingAs($this->admin)->getJson(route('admin.kiosks.remote-login.status', $id))
            ->assertOk()
            ->assertJsonPath('request.status', 'expired');
    }
}
