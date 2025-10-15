<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('stores', function (Blueprint $table) {
        $table->string('new_contact_number')->nullable();
        $table->enum('contact_status', ['pending', 'approved'])->default('pending')->nullable();
    });
}

    public function down()
{
    Schema::table('stores', function (Blueprint $table) {
        $table->dropColumn('new_contact_number');
        $table->dropColumn('contact_status');
    });
}
};
