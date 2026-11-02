<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // One row per remote-login request: the one-time request itself and its audit trail
        Schema::create('kiosk_remote_logins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kiosk_status_id')->nullable()->index();
            $table->string('kiosk_id');
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('target_user_id')->nullable();
            $table->string('approved_username')->nullable();
            $table->string('verified_role', 50)->nullable();
            $table->unsignedBigInteger('requested_by');
            // pending, delivered, completed, expired, failed, cancelled, rejected
            $table->string('status', 20)->index();
            $table->string('failure_reason')->nullable();
            // SHA-256 of the one-time token handed to the kiosk; cleared once used
            $table->string('token_hash', 64)->nullable();
            $table->string('kiosk_ip', 45)->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kiosk_remote_logins');
    }
};
