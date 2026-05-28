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
        Schema::create('product_stocks', function (Blueprint $table) {
            $table->id();
        
            $table->string('product_id');
            $table->string('product_name')->nullable();
            $table->string('product_category')->nullable();
            $table->string('product_subcategory')->nullable();
        
            $table->string('qty_per_unit')->nullable();
        
            $table->integer('stock')->default(0);
        
            $table->string('location')->nullable();
        
            $table->decimal('mrp', 10, 2)->nullable();
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_stocks');
    }
};
