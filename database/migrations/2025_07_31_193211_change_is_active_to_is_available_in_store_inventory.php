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
        Schema::table('store_inventory', function (Blueprint $table) {
            // Rename is_active to is_available
            $table->renameColumn('is_active', 'is_available');
            
            // Drop is_featured column if it exists
            if (Schema::hasColumn('store_inventory', 'is_featured')) {
                $table->dropColumn('is_featured');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('store_inventory', function (Blueprint $table) {
            // Revert the column name back to is_active
            $table->renameColumn('is_available', 'is_active');
            
            // Re-add is_featured column (without data, as we can't recover the original data in a down migration)
            if (!Schema::hasColumn('store_inventory', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('is_available');
            }
        });
    }
};
