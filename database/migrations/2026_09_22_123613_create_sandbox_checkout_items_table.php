<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sandbox_checkout_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('store_manager_upload_id')->nullable();

            $table->unsignedBigInteger('checkout_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('store_manager_id')->nullable();

            $table->string('product_name');

            $table->decimal('price', 10, 2)->default(0);

            $table->integer('quantity')->default(1);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sandbox_checkout_items');
    }
};