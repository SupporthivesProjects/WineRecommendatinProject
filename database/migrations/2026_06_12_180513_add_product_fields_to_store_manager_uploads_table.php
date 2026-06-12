<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('store_manager_uploads', function (Blueprint $table) {

            $table->string('product_id')->nullable()->after('product_name');

            $table->string('product_category')->nullable()->after('product_id');

            $table->string('product_sub_category')->nullable()->after('product_category');

            $table->string('size')->nullable()->after('product_sub_category');

            $table->string('packsize')->nullable()->after('size');

            $table->integer('qty_per_unit')->nullable()->after('packsize');

            $table->integer('stock')->nullable()->after('qty_per_unit');

            $table->string('location')->nullable()->after('stock');

            $table->timestamp('product_created_time')
                ->nullable()
                ->after('location');

            $table->timestamp('product_modified_time')
                ->nullable()
                ->after('product_created_time');
        });
    }

    public function down(): void
    {
        Schema::table('store_manager_uploads', function (Blueprint $table) {

            $table->dropColumn([
                'product_id',
                'product_category',
                'product_sub_category',
                'size',
                'packsize',
                'qty_per_unit',
                'stock',
                'location',
                'product_created_time',
                'product_modified_time'
            ]);
        });
    }
};