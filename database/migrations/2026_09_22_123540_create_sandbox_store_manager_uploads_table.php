<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sandbox_store_manager_uploads', function (Blueprint $table) {
            $table->id();

            $table->string('store_manager_name');
            $table->unsignedBigInteger('store_manager_id');

            $table->string('invoice_no')->nullable();

            $table->string('customer_name')->nullable();
            $table->string('customer_mobile')->nullable();

            $table->string('product_name');
            $table->string('product_id')->nullable();

            $table->string('product_category')->nullable();
            $table->string('product_sub_category')->nullable();

            $table->decimal('product_price', 10, 2)->nullable();

            $table->string('size')->nullable();
            $table->string('packsize')->nullable();

            $table->integer('qty')->nullable();
            $table->integer('stock')->nullable();

            $table->string('location')->nullable();

            $table->dateTime('product_created_time')->nullable();
            $table->dateTime('product_modified_time')->nullable();

            $table->string('type')->nullable();
            $table->date('date')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sandbox_store_manager_uploads');
    }
};