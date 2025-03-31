<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('store_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('product_id');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            
            // Ensure a product can only be added once per store
            $table->unique(['store_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_products');
    }
};
