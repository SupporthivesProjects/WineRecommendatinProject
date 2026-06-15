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
        Schema::create('question_mappings', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('template_id');

            $table->string('question_key');

            $table->string('question_type')->index();

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_mappings');
    }
};
