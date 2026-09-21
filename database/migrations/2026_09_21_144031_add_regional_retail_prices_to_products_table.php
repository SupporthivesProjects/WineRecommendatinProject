<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('retail_price_maharashtra', 10, 2)
                ->nullable()
                ->after('retail_price');

            $table->decimal('retail_price_kolkata', 10, 2)
                ->nullable()
                ->after('retail_price_maharashtra');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'retail_price_maharashtra',
                'retail_price_kolkata',
            ]);
        });
    }
};