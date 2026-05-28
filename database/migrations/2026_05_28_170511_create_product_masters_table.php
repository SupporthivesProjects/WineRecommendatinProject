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
        Schema::create('product_masters', function (Blueprint $table) {
            $table->id();
        
            $table->string('product_id')->unique();
            $table->string('product_name')->nullable();
            $table->string('product_category')->nullable();
            $table->string('size')->nullable();
            $table->string('pack_size')->nullable();
            $table->string('type')->nullable();
        
            $table->timestamp('product_created_time')->nullable();
            $table->timestamp('product_modified_time')->nullable();
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_masters');
    }
};
