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
    Schema::create('questions', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('template_id');
        $table->string('question');
        $table->string('type'); // e.g., radio, checkbox, range, etc.

        // 15 options
        for ($i = 1; $i <= 15; $i++) {
            $table->string("option_$i")->nullable();
        }

        // For range slider type
       $table->integer('min_value')->nullable();
       $table->integer('max_value')->nullable();
       $table->integer('step')->nullable(); // Add this line
       $table->integer('default')->nullable(); // You can also add this if needed

        $table->timestamps();

        $table->foreign('template_id')->references('id')->on('questionnaire_templates')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
