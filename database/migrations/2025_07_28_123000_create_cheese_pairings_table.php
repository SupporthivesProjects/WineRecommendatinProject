<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cheese_pairings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Pivot table for many-to-many relationship between pairings and cheese products
        Schema::create('cheese_pairing_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pairing_id')->constrained('cheese_pairings')->onDelete('cascade');
            $table->foreignId('cheese_product_id')->constrained('cheese_products')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cheese_pairing_product');
        Schema::dropIfExists('cheese_pairings');
    }
};
