<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cheese_products', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('price');
        });
    }

    public function down()
    {
        Schema::table('cheese_products', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
