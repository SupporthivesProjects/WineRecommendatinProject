<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Add to cart / Remove from cart: the cart count is the number of bottles, and adding
 * a wine that is already in the cart sets its quantity instead of adding to it.
 */
class CartTest extends TestCase
{
    private User $user;

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

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('wine_name')->nullable();
            $table->string('image1')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        foreach (range(1, 8) as $id) {
            DB::table('products')->insert(['id' => $id, 'wine_name' => "Wine $id", 'image1' => "products/$id.jpg"]);
        }

        $this->user = User::create([
            'email' => 'kiosk@example.test',
            'password' => 'password',
            'role' => 'user',
            'status' => 'active',
            'store_id' => 1,
        ]);
    }

    private function add(int $productId, array $extra = [])
    {
        return $this->actingAs($this->user)->postJson('/user/cart/add', array_merge([
            'product_id' => $productId,
            'product_name' => "Wine $productId",
            'product_price' => 500,
        ], $extra));
    }

    public function test_more_than_five_wines_can_be_added(): void
    {
        foreach (range(1, 8) as $id) {
            $this->add($id)->assertOk()->assertJson(['success' => true, 'cart_count' => $id]);
        }

        $this->assertCount(8, session('cart'));
    }

    public function test_adding_a_wine_twice_does_not_raise_the_count(): void
    {
        $this->add(1)->assertJson(['cart_count' => 1]);
        $this->add(2)->assertJson(['cart_count' => 2]);
        $this->add(2)->assertJson(['cart_count' => 2]);

        $this->assertSame(1, session('cart')[1]['quantity']);
    }

    public function test_quantity_is_kept_and_limited_to_ten(): void
    {
        $this->add(1, ['quantity' => 3])->assertJson(['cart_count' => 3]);
        $this->add(2, ['quantity' => 50])->assertJson(['cart_count' => 13]);

        $this->assertSame(10, session('cart')[1]['quantity']);
    }

    public function test_remove_updates_the_count(): void
    {
        foreach (range(1, 5) as $id) {
            $this->add($id);
        }

        $this->actingAs($this->user)->postJson('/user/cart/remove', ['product_id' => 3])
            ->assertOk()->assertJson(['success' => true, 'cart_count' => 4]);
        $this->assertSame([1, 2, 4, 5], array_map('intval', array_column(session('cart'), 'id')));

        // Removing it again (a stale button) changes nothing
        $this->actingAs($this->user)->postJson('/user/cart/remove', ['product_id' => 3])
            ->assertJson(['cart_count' => 4]);
    }

    public function test_unknown_wine_is_refused(): void
    {
        $this->add(999)->assertNotFound()->assertJson(['success' => false]);
        $this->assertSame([], session('cart', []));
    }
}
