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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('wine_name');
            $table->string('type')->nullable();
            $table->text('sp_mentions')->nullable();
            $table->string('grape_variety')->nullable();
            $table->string('varietal_blend')->nullable();
            $table->string('vintage_year')->nullable();
            $table->string('wine_sub_region')->nullable();
            $table->string('winery')->nullable();
            $table->string('designation')->nullable();
            $table->string('alcohol_vol')->nullable();
            $table->string('residual_sugar')->nullable();
            $table->string('nature')->nullable();
            $table->string('acidity')->nullable();
            $table->string('tannin_level')->nullable();
            $table->string('body')->nullable();
            $table->string('aging')->nullable();
            $table->string('barrel_type')->nullable();
            $table->string('time_spent_aging')->nullable();
            $table->string('closure_type')->nullable();
            $table->text('aroma')->nullable();
            $table->text('palate')->nullable();
            $table->text('finish')->nullable();
            $table->string('sweetness_level')->nullable();
            $table->string('glass_ware')->nullable();
            $table->decimal('retail_price', 10, 2)->nullable();
            $table->string('discounts')->nullable();
            $table->string('optimal_drinking')->nullable();
            $table->string('style')->nullable();
            $table->string('decanting_time')->nullable();
            $table->string('ageing_potential')->nullable();
            $table->string('cheese_pairing')->nullable();
            $table->string('importer_info')->nullable();
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->string('image4')->nullable();
            $table->text('wine_story')->nullable();
            $table->string('country')->nullable();
            $table->text('tasting_notes')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
