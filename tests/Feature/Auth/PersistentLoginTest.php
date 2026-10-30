<?php

namespace Tests\Feature\Auth;

use App\Http\Middleware\EnforceLoginExpiry;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

/**
 * Runs against its own in-memory SQLite database so it never touches the
 * application's real database.
 */
class PersistentLoginTest extends TestCase
{
    private const PROBE = '/_test/persistent-login-probe';

    private const ADMIN_PROBE = '/_test/persistent-login-admin-probe';

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
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('user');
            $table->string('status')->default('active');
            $table->rememberToken();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('previous_login_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Route::middleware(['web', 'auth'])->get(self::PROBE, fn () => response(Auth::user()->role));
        Route::middleware(['web', 'auth', 'admin'])->get(self::ADMIN_PROBE, fn () => response('admin area'));
    }

    public static function roles(): array
    {
        return [
            'admin' => ['admin'],
            'subadmin' => ['sub_admin'],
            'user' => ['user'],
        ];
    }

    private function makeUser(string $role): User
    {
        return User::create([
            'first_name' => 'Test',
            'last_name' => $role,
            'email' => $role.'@example.test',
            'password' => 'password',
            'role' => $role,
            'status' => 'active',
        ]);
    }

    private function login(User $user): TestResponse
    {
        // No "remember" field: persistence must not depend on the checkbox.
        return $this->post('/login', ['email' => $user->email, 'password' => 'password']);
    }

    /**
     * Collect the persistent cookies a browser would keep after a restart.
     */
    private function persistentCookies(TestResponse $response): array
    {
        $recaller = Auth::guard('web')->getRecallerName();

        return [
            $recaller => $response->getCookie($recaller)->getValue(),
            EnforceLoginExpiry::COOKIE_NAME => $response->getCookie(EnforceLoginExpiry::COOKIE_NAME)->getValue(),
        ];
    }

    /**
     * Simulate a fresh browser start: no server session, only stored cookies.
     */
    private function freshBrowser(): void
    {
        Auth::forgetGuards();
        $this->app['session']->forgetDrivers();
        $this->app->forgetInstance('session.store');
        $this->flushHeaders();
        $this->defaultCookies = [];
        $this->unencryptedCookies = [];
    }

    /** @dataProvider roles */
    public function test_login_issues_fifteen_day_persistent_cookies(string $role): void
    {
        $user = $this->makeUser($role);

        $response = $this->login($user);

        $this->assertAuthenticatedAs($user);
        $fifteenDays = now()->addDays(15)->getTimestamp();

        $recaller = $response->getCookie(Auth::guard('web')->getRecallerName(), false);
        $this->assertNotNull($recaller, 'Remember-me cookie must be issued even without the checkbox.');
        $this->assertEqualsWithDelta($fifteenDays, $recaller->getExpiresTime(), 5);
        $this->assertNotNull($user->fresh()->remember_token);

        $expiry = $response->getCookie(EnforceLoginExpiry::COOKIE_NAME, false);
        $this->assertNotNull($expiry);
        $this->assertEqualsWithDelta($fifteenDays, $expiry->getExpiresTime(), 5);
        $this->assertTrue($expiry->isHttpOnly());
        $this->assertEqualsWithDelta($fifteenDays, (int) session(EnforceLoginExpiry::SESSION_KEY), 5);
    }

    /** @dataProvider roles */
    public function test_login_survives_browser_restart_and_inactivity_until_day_fourteen(string $role): void
    {
        $user = $this->makeUser($role);
        $loginTime = now();
        $cookies = $this->persistentCookies($this->login($user));

        foreach ([1, 5, 10, 14] as $day) {
            $this->travelTo($loginTime->copy()->addDays($day));
            $this->freshBrowser();

            $this->withCookies($cookies)->get(self::PROBE)
                ->assertOk()
                ->assertSee($role);

            $this->assertTrue(Auth::guard('web')->viaRemember(), "Day {$day} should be restored from the remember-me cookie.");
        }
    }

    /** @dataProvider roles */
    public function test_login_expires_fifteen_days_after_original_login_despite_activity(string $role): void
    {
        $user = $this->makeUser($role);
        $loginTime = now();
        $cookies = $this->persistentCookies($this->login($user));

        // Activity on day 14 must not push the expiry forward.
        $this->travelTo($loginTime->copy()->addDays(14));
        $this->freshBrowser();
        $this->withCookies($cookies)->get(self::PROBE)->assertOk();

        $this->travelTo($loginTime->copy()->addDays(15)->addMinute());
        $this->freshBrowser();
        $this->withCookies($cookies)->get(self::PROBE)->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_active_session_also_expires_after_fifteen_days(): void
    {
        $user = $this->makeUser('admin');
        $loginTime = now();
        $this->login($user);

        // Same server session kept alive by continuous activity.
        $this->travelTo($loginTime->copy()->addDays(10));
        Auth::forgetGuards();
        $this->get(self::PROBE)->assertOk();

        $this->travelTo($loginTime->copy()->addDays(15));
        Auth::forgetGuards();
        $this->get(self::PROBE)->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_remember_cookie_without_login_expiry_is_rejected(): void
    {
        $user = $this->makeUser('user');
        $cookies = $this->persistentCookies($this->login($user));
        unset($cookies[EnforceLoginExpiry::COOKIE_NAME]);

        $this->freshBrowser();
        $this->withCookies($cookies)->get(self::PROBE)->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_tampered_login_expiry_cookie_cannot_extend_login(): void
    {
        $user = $this->makeUser('user');
        $loginTime = now();
        $cookies = $this->persistentCookies($this->login($user));

        $this->travelTo($loginTime->copy()->addDays(16));
        $this->freshBrowser();

        // An unencrypted (forged) expiry value is discarded by EncryptCookies.
        $this->withCookie(Auth::guard('web')->getRecallerName(), $cookies[Auth::guard('web')->getRecallerName()])
            ->withUnencryptedCookie(EnforceLoginExpiry::COOKIE_NAME, (string) now()->addDays(30)->getTimestamp())
            ->get(self::PROBE)
            ->assertRedirect('/login');
        $this->assertGuest();
    }

    /** @dataProvider roles */
    public function test_logout_invalidates_persistent_login(string $role): void
    {
        $user = $this->makeUser($role);
        $cookies = $this->persistentCookies($this->login($user));
        $tokenBefore = $user->fresh()->remember_token;

        Auth::forgetGuards();
        $response = $this->withCookies($cookies)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
        $this->assertNotSame($tokenBefore, $user->fresh()->remember_token, 'Logout must rotate the remember token.');
        $this->assertTrue($response->getCookie(Auth::guard('web')->getRecallerName(), false)->isCleared());

        // Replaying the old cookies after logout must not log the user back in.
        $this->freshBrowser();
        $this->withCookies($cookies)->get(self::PROBE)->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_inactive_user_still_cannot_log_in(): void
    {
        $user = $this->makeUser('user');
        $user->update(['status' => 'inactive']);

        $this->login($user)->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_role_based_access_is_preserved_after_restore(): void
    {
        foreach (['admin' => true, 'sub_admin' => true, 'user' => false] as $role => $allowed) {
            $user = $this->makeUser($role);
            $this->freshBrowser();
            $cookies = $this->persistentCookies($this->login($user));

            $this->travel(3)->days();
            $this->freshBrowser();
            $response = $this->withCookies($cookies)->get(self::ADMIN_PROBE);

            $allowed ? $response->assertOk() : $response->assertRedirect(route('home'));
            $this->travelBack();
        }
    }
}
