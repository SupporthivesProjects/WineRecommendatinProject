<?php

namespace Tests\Feature;

use App\Models\SiteAnalyticsEvent;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Website Health analytics: which requests count as page views, what the click endpoint
 * accepts, and who may open the admin page.
 */
class WebsiteHealthTrackingTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);
        DB::purge('sqlite');

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

        (require database_path('migrations/2026_11_03_100000_create_site_analytics_events_table.php'))->up();

        // Small stand-in pages that go through the normal "web" middleware
        Route::middleware('web')->group(function () {
            Route::get('/__health/page', fn () => response('<html><body>page</body></html>'))->name('user.dashboard');
            Route::get('/__health/wine/{id}', fn ($id) => response('<html><body>wine</body></html>'))->name('user.productdetails');
            Route::get('/__health/json', fn () => response()->json(['ok' => true]))->name('user.cart.get');
            Route::get('/__health/missing', fn () => abort(404))->name('user.missing');
        });
    }

    private function makeUser(string $role, string $email, ?int $storeId = 1): User
    {
        return User::create([
            'email' => $email,
            'password' => 'password',
            'role' => $role,
            'status' => 'active',
            'store_id' => $storeId,
        ]);
    }

    public function test_kiosk_user_page_view_is_recorded(): void
    {
        $user = $this->makeUser('user', 'kiosk@example.test');

        $this->actingAs($user)->get('/__health/page')->assertOk();

        $event = SiteAnalyticsEvent::sole();
        $this->assertSame('page_view', $event->event);
        $this->assertSame('user.dashboard', $event->route_name);
        $this->assertSame('/__health/page', $event->path);
        $this->assertSame($user->id, (int) $event->user_id);
        $this->assertSame(1, (int) $event->store_id);
    }

    public function test_wine_page_view_records_the_wine(): void
    {
        $this->actingAs($this->makeUser('user', 'kiosk@example.test'))->get('/__health/wine/42')->assertOk();

        $this->assertSame(42, (int) SiteAnalyticsEvent::sole()->product_id);
    }

    public function test_background_json_and_failed_requests_are_not_page_views(): void
    {
        $this->actingAs($this->makeUser('user', 'kiosk@example.test'));

        $this->get('/__health/page', ['X-Requested-With' => 'XMLHttpRequest'])->assertOk();
        $this->getJson('/__health/page')->assertOk();
        $this->get('/__health/json')->assertOk();
        $this->get('/__health/missing')->assertNotFound();

        $this->assertSame(0, SiteAnalyticsEvent::count());
    }

    public function test_only_kiosk_users_are_measured(): void
    {
        $this->get('/__health/page')->assertOk();
        foreach (['admin', 'sub_admin', 'store_manager', 'main_manager'] as $role) {
            $this->actingAs($this->makeUser($role, $role . '@example.test'))->get('/__health/page')->assertOk();
        }

        $this->assertSame(0, SiteAnalyticsEvent::count());
    }

    public function test_click_is_recorded_for_kiosk_users(): void
    {
        $this->actingAs($this->makeUser('user', 'kiosk@example.test'))
            ->post('/analytics/click', [
                'label' => "  Add   to cart ",
                'target' => '',
                'route' => 'user.products',
                'path' => '/user/products',
                'product_id' => 7,
            ])->assertNoContent();

        $event = SiteAnalyticsEvent::sole();
        $this->assertSame('click', $event->event);
        $this->assertSame('Add to cart', $event->label);
        $this->assertSame('user.products', $event->route_name);
        $this->assertSame(7, (int) $event->product_id);
    }

    public function test_click_endpoint_rejects_bad_input_and_ignores_other_roles(): void
    {
        $this->actingAs($this->makeUser('user', 'kiosk@example.test'))
            ->postJson('/analytics/click', ['path' => '/user/products'])->assertStatus(422);
        $this->actingAs($this->makeUser('user', 'kiosk2@example.test'))
            ->postJson('/analytics/click', ['label' => str_repeat('x', 151), 'path' => '/x'])->assertStatus(422);

        $this->actingAs($this->makeUser('admin', 'admin@example.test', null))
            ->post('/analytics/click', ['label' => 'Dashboard', 'path' => '/admin'])->assertNoContent();

        $this->assertSame(0, SiteAnalyticsEvent::count());
    }

    public function test_guests_cannot_send_clicks(): void
    {
        $this->post('/analytics/click', ['label' => 'Home', 'path' => '/'])->assertRedirect();
        $this->assertSame(0, SiteAnalyticsEvent::count());
    }

    public function test_only_the_main_administrator_can_open_website_health(): void
    {
        $this->actingAs($this->makeUser('sub_admin', 'sub@example.test', null))
            ->get('/admin/website-health')->assertForbidden();

        $this->actingAs($this->makeUser('store_manager', 'manager@example.test'))
            ->get('/admin/website-health')->assertRedirect();

        $this->actingAs($this->makeUser('user', 'kiosk@example.test'))
            ->get('/admin/website-health')->assertRedirect();
    }
}
