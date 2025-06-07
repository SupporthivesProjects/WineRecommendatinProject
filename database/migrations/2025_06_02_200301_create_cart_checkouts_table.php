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
        Schema::create('cart_checkouts', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email');
            $table->string('phone');
            $table->string('submission_id');
            $table->json('products'); // store selected product IDs as JSON
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_checkouts');
    }
};
