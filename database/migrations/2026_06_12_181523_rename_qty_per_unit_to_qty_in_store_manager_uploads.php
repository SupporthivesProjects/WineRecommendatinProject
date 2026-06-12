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
        Schema::table('store_manager_uploads', function (Blueprint $table) {
            $table->renameColumn(
                'qty_per_unit',
                'qty'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('store_manager_uploads', function (Blueprint $table) {
            $table->renameColumn(
                'qty_per_unit',
                'qty'
            );
        });
    }
};
