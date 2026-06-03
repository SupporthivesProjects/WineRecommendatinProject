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
        Schema::create('template_cheese_products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('template_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('cheese_product_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'template_id',
                'cheese_product_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_cheese_products');
    }
};
