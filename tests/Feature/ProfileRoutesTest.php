<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Runs against its own in-memory SQLite database so it never touches the
 * application's real database.
 */
class ProfileRoutesTest extends TestCase
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
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('user');
            $table->string('status')->default('active');
            $table->unsignedBigInteger('store_id')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function test_profile_urls_resolve_to_the_live_controllers(): void
    {
        $this->assertSame('user.userprofile.show', Route::getRoutes()->match(request()->create('/user/profile'))->getName());
        $this->assertSame('user.storeprofile.show', Route::getRoutes()->match(request()->create('/profile'))->getName());
        $this->assertFalse(Route::has('profile.edit'));
        $this->assertFalse(Route::has('user.profile'));
    }

    public function test_profile_pages_require_login(): void
    {
        foreach (['/user/profile', '/profile', '/store-tab-profile'] as $uri) {
            $this->get($uri)->assertRedirect('/login');
        }
    }

    public function test_layouts_with_profile_link_render_for_logged_in_user(): void
    {
        $user = User::create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'user@example.test',
            'password' => 'password',
            'role' => 'user',
        ]);
        $this->actingAs($user);

        $html = view('layouts.navigation')->render();

        $this->assertStringContainsString(route('user.userprofile.show'), $html);
    }
}
