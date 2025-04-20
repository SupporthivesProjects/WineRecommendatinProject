<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, check if the column is ENUM type
        $connection = DB::connection()->getPdo();
        $dbName = DB::connection()->getDatabaseName();
        
        $stmt = $connection->prepare("
            SELECT COLUMN_TYPE 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_SCHEMA = ? 
            AND TABLE_NAME = 'users' 
            AND COLUMN_NAME = 'role'
        ");
        $stmt->execute([$dbName]);
        $columnType = $stmt->fetchColumn();
        
        // If it's an ENUM, update it to include 'customer'
        if (strpos($columnType, 'enum') === 0) {
            // Extract current values
            preg_match("/^enum\((.*)\)$/", $columnType, $matches);
            $values = str_getcsv($matches[1], ',', "'");
            
            // Add 'customer' if it doesn't exist
            if (!in_array('customer', $values)) {
                $values[] = 'customer';
                $valuesString = "'" . implode("','", $values) . "'";
                
                DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM($valuesString) NOT NULL");
            }
        } else {
            // If it's not an ENUM, you might want to convert it to one
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'store_manager', 'customer') NOT NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // You can revert to the original column definition if needed
        // This is a simplified example - you might want to save the original definition
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'store_manager') NOT NULL");
    }
};
