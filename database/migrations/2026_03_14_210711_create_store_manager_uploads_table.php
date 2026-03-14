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
        Schema::create('store_manager_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('store_manager_name');
            $table->string('store_manager_id');
            $table->string('invoice_no');
            $table->string('customer_name');
            $table->string('customer_mobile');
            $table->string('product_name');
            $table->decimal('product_price',10,2);
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_manager_uploads');
    }
};
