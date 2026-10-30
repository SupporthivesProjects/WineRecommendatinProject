<?php

namespace Tests\Feature;

use App\Http\Controllers\Admin\QuestionnaireDebuggerController;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Access-control fixes from the October 2026 audit.
 * Runs against its own in-memory SQLite database so it never touches the real one.
 */
class SecurityFixesTest extends TestCase
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

        Schema::create('store_manager_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('store_manager_name')->nullable();
            $table->unsignedBigInteger('store_manager_id')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_mobile')->nullable();
            $table->string('product_name')->nullable();
            $table->string('product_id')->nullable();
            $table->string('product_category')->nullable();
            $table->string('product_sub_category')->nullable();
            $table->decimal('product_price', 10, 2)->nullable();
            $table->string('size')->nullable();
            $table->string('packsize')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('stock')->nullable();
            $table->string('location')->nullable();
            $table->dateTime('product_created_time')->nullable();
            $table->dateTime('product_modified_time')->nullable();
            $table->string('type')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->integer('rating')->nullable();
            $table->text('comment')->nullable();
            $table->string('status')->default('pending');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('checkout_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_manager_upload_id')->nullable();
            $table->string('product_name')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->timestamps();
        });
    }

    private function makeUser(string $role, string $email): User
    {
        return User::create([
            'first_name' => 'Test',
            'last_name' => $role,
            'email' => $email,
            'password' => 'password',
            'role' => $role,
            'status' => 'active',
        ]);
    }

    public function test_review_status_update_requires_an_admin(): void
    {
        $reviewId = DB::table('reviews')->insertGetId(['rating' => 4, 'status' => 'pending', 'created_at' => now(), 'updated_at' => now()]);

        $this->put("/admin/reviews/{$reviewId}/update-status", ['status' => 'approved'])
            ->assertRedirect('/login');

        $this->actingAs($this->makeUser('user', 'user@example.test'))
            ->put("/admin/reviews/{$reviewId}/update-status", ['status' => 'approved'])
            ->assertRedirect(route('home'));

        $this->assertSame('pending', DB::table('reviews')->where('id', $reviewId)->value('status'));

        $this->actingAs($this->makeUser('admin', 'admin@example.test'))
            ->put("/admin/reviews/{$reviewId}/update-status", ['status' => 'approved'])
            ->assertRedirect();

        $this->assertSame('approved', DB::table('reviews')->where('id', $reviewId)->value('status'));
    }

    public function test_password_update_requires_login(): void
    {
        $this->post('/profile/update-password', [])->assertRedirect('/login');
    }

    public function test_breeze_self_delete_and_update_endpoints_are_gone(): void
    {
        $user = $this->makeUser('user', 'user@example.test');

        $this->actingAs($user)->delete('/profile', ['password' => 'password'])->assertStatus(405);
        $this->actingAs($user)->patch('/profile', ['email' => 'x@example.test'])->assertStatus(405);
        $this->assertNotNull($user->fresh());
    }

    public function test_debugger_query_endpoint_rejects_sub_admins(): void
    {
        $this->actingAs($this->makeUser('sub_admin', 'sub@example.test'))
            ->postJson(route('admin.questionnaire.executeQuery'), [
                'sql' => base64_encode('select * from `products` where `id` in (?)'),
                'bindings' => json_encode([1]),
            ])
            ->assertStatus(403);
    }

    public function test_debugger_query_endpoint_rejects_non_product_sql_for_admins(): void
    {
        $admin = $this->makeUser('admin', 'admin@example.test');

        foreach ([
            'select * from `users`',
            'delete from `products` where `id` in (?)',
            'select * from `products` where `id` in (?) union select password from users',
            'select * from `products` where `id` in (select id from users)',
            'select * from `products` where `id` in (?); drop table products',
        ] as $sql) {
            $this->actingAs($admin)
                ->postJson(route('admin.questionnaire.executeQuery'), [
                    'sql' => base64_encode($sql),
                    'bindings' => json_encode([1]),
                ])
                ->assertStatus(422);
        }
    }

    public function test_debugger_filter_accepts_the_queries_the_matcher_logs(): void
    {
        $method = new \ReflectionMethod(QuestionnaireDebuggerController::class, 'isAllowedProductQuery');
        $method->setAccessible(true);
        $controller = new QuestionnaireDebuggerController();

        // Real shapes taken from storage/logs/laravel.log
        foreach ([
            'select * from `products` where `id` in (?, ?) and `status` = ? and (`country` like ?) and `products`.`deleted_at` is null',
            'select * from `products` where `id` in (?) and `status` = ? and (`type` like ? or `method` like ?) and `products`.`deleted_at` is null',
            'select * from `products` where `id` in (?) and `status` = ? and `retail_price` between ? and ? and `products`.`deleted_at` is null',
            'select * from `products` where `id` in (?) and `status` = ? and (`nature` in (?)) and `products`.`deleted_at` is null',
        ] as $sql) {
            $this->assertTrue($method->invoke($controller, $sql), $sql);
        }

        foreach ([
            'select * from `products` join `users` on 1=1',
            'select * from `products` where `id` = ? -- comment',
            'select * from `products` where `id` in (?) and sleep(5)',
            'select * from `products` into outfile \'/tmp/x\'',
            'select * from `products` where `users`.`id` = ?',
        ] as $sql) {
            $this->assertFalse($method->invoke($controller, $sql), $sql);
        }
    }

    public function test_store_manager_cannot_edit_another_managers_upload(): void
    {
        $owner = $this->makeUser('store_manager', 'owner@example.test');
        $other = $this->makeUser('store_manager', 'other@example.test');
        $id = DB::table('store_manager_uploads')->insertGetId([
            'store_manager_id' => $owner->id, 'product_name' => 'Original', 'qty' => 1, 'created_at' => now(), 'updated_at' => now(),
        ]);

        $this->actingAs($other)
            ->postJson("/store-manager/uploads/update/{$id}", ['product_name' => 'Hacked', 'qty' => 2])
            ->assertNotFound();
        $this->assertSame('Original', DB::table('store_manager_uploads')->where('id', $id)->value('product_name'));

        $this->actingAs($owner)
            ->postJson("/store-manager/uploads/update/{$id}", [
                'product_name' => 'Edited', 'qty' => 3, 'product_price' => '12.50',
                'product_created_time' => '2026-06-15T16:27',
            ])
            ->assertOk()->assertJson(['success' => true]);
        $this->assertSame('Edited', DB::table('store_manager_uploads')->where('id', $id)->value('product_name'));
    }

    public function test_store_manager_upload_edit_validates_types(): void
    {
        $owner = $this->makeUser('store_manager', 'owner@example.test');
        $id = DB::table('store_manager_uploads')->insertGetId([
            'store_manager_id' => $owner->id, 'product_name' => 'Original', 'created_at' => now(), 'updated_at' => now(),
        ]);

        $this->actingAs($owner)
            ->postJson("/store-manager/uploads/update/{$id}", ['qty' => 'lots', 'product_price' => 'free'])
            ->assertStatus(422)->assertJsonValidationErrors(['qty', 'product_price']);
    }

    public function test_public_testimonial_rejects_svg_images(): void
    {
        $svg = UploadedFile::fake()->createWithContent('logo.svg', '<svg xmlns="http://www.w3.org/2000/svg"><script>alert(1)</script></svg>');

        $this->post('/testimonials', [
            'testimonial' => 'A lovely selection of wines.',
            'rating' => 5,
            'image' => $svg,
        ])->assertSessionHasErrors('image');
    }
}
