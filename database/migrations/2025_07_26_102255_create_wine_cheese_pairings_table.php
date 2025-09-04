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
        Schema::create('wine_cheese_pairings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wine_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('cheese_id')->constrained('cheeses')->onDelete('cascade');
            $table->string('pairing_strength')->default('medium'); // e.g., 'excellent', 'good', 'medium'
            $table->text('pairing_notes')->nullable(); // why this pairing works
            $table->boolean('is_recommended')->default(true);
            $table->timestamps();

            // Ensure unique wine-cheese pairing combinations
            $table->unique(['wine_id', 'cheese_id']);
            
            // Add indexes for better query performance
            $table->index(['wine_id']);
            $table->index(['cheese_id']);
            $table->index(['is_recommended']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wine_cheese_pairings');
    }
};
