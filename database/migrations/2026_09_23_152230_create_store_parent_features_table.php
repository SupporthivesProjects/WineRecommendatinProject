<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('store_parent_features', function (Blueprint $table) {
            $table->id();

            $table->foreignId('store_id')
                ->constrained('stores')
                ->onDelete('cascade');

            $table->foreignId('feature_id')
                ->constrained('features')
                ->onDelete('cascade');

            $table->boolean('enabled')->default(false);

            $table->timestamps();

            $table->unique(['store_id', 'feature_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_parent_features');
    }
};