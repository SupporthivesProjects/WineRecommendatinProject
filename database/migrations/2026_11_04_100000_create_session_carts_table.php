<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // The cart of each logged-in browser session, kept outside the session payload so that
        // other requests saving the session (page loads, analytics, heartbeat) cannot overwrite it
        Schema::create('session_carts', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->longText('items');
            $table->timestamps();

            $table->index('updated_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session_carts');
    }
};
