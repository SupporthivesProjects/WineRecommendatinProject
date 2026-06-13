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
        Schema::table('checkout_items', function (Blueprint $table) {

            $table->unsignedBigInteger('store_manager_upload_id')
                ->nullable()
                ->after('id');

        });
    }

    public function down(): void
    {
        Schema::table('checkout_items', function (Blueprint $table) {

            $table->dropColumn(
                'store_manager_upload_id'
            );

        });
    }
};
