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
        // First, check if we need to rename is_active to is_available in store_inventory
        Schema::table('store_inventory', function (Blueprint $table) {
            if (Schema::hasColumn('store_inventory', 'is_active') && !Schema::hasColumn('store_inventory', 'is_available')) {
                $table->renameColumn('is_active', 'is_available');
            }
            
            // Drop is_featured column if it exists
            if (Schema::hasColumn('store_inventory', 'is_featured')) {
                $table->dropColumn('is_featured');
            }
        });

        // Fix the cheese_products table if needed
        Schema::table('cheese_products', function (Blueprint $table) {
            // If is_active doesn't exist, add it
            if (!Schema::hasColumn('cheese_products', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('price');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Revert the changes if needed
        Schema::table('store_inventory', function (Blueprint $table) {
            if (Schema::hasColumn('store_inventory', 'is_available') && !Schema::hasColumn('store_inventory', 'is_active')) {
                $table->renameColumn('is_available', 'is_active');
            }
        });
        
        // We won't re-add the is_featured column in the down migration
        // as we don't have the original data
    }
};
