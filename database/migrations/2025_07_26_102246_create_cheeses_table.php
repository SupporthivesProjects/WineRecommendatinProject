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
        Schema::create('cheeses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->string('type')->nullable(); // e.g., 'soft', 'hard', 'semi-hard', 'blue'
            $table->string('texture')->nullable(); // e.g., 'creamy', 'crumbly', 'firm'
            $table->string('origin_country')->nullable();
            $table->string('milk_type')->nullable(); // e.g., 'cow', 'goat', 'sheep'
            $table->decimal('fat_content', 5, 2)->nullable(); // percentage
            $table->text('flavor_profile')->nullable();
            $table->string('aging_period')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(true); // active/inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cheeses');
    }
};
