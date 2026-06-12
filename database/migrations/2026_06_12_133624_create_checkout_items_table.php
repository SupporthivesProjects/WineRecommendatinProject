<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checkout_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('checkout_id');
            $table->unsignedBigInteger('product_id');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('store_manager_id')->nullable();

            $table->string('product_name');

            $table->decimal('price', 10, 2);

            $table->integer('quantity');

            $table->timestamps();

            $table->index('checkout_id');
            $table->index('product_id');
            $table->index('store_manager_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checkout_items');
    }
};