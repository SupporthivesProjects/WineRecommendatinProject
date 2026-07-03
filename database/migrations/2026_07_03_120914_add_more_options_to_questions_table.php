<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1 - Reduce existing option columns
        Schema::table('questions', function (Blueprint $table) {
            for ($i = 1; $i <= 15; $i++) {
                $table->string("option_$i", 100)->nullable()->change();
            }
        });

        // Step 2 - Add new option columns
        Schema::table('questions', function (Blueprint $table) {
            for ($i = 16; $i <= 71; $i++) {
                $table->string("option_$i", 100)->nullable();
            }
        });
    }

    public function down(): void
    {
        // Remove new columns
        Schema::table('questions', function (Blueprint $table) {
            for ($i = 16; $i <= 71; $i++) {
                $table->dropColumn("option_$i");
            }
        });

        // Restore original size
        Schema::table('questions', function (Blueprint $table) {
            for ($i = 1; $i <= 15; $i++) {
                $table->string("option_$i", 255)->nullable()->change();
            }
        });
    }
};