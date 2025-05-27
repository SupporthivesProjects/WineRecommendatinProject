<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('question_responses', function (Blueprint $table) {
            $table->unsignedBigInteger('customerID')->nullable()->after('submission_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('question_responses', function (Blueprint $table) {
            $table->dropColumn('customerID');
        });
    }
};
