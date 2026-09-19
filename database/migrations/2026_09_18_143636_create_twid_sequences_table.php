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
        Schema::create('twid_sequences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('last_number')->default(0);
            $table->timestamps();
        });

        DB::table('twid_sequences')->insert([
            'id' => 1,
            'last_number' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('twid_sequences');
    }
};
