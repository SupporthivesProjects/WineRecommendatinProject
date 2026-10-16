
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kiosk_statuses', function (Blueprint $table) {
            $table->id();

            // Unique identity for each physical kiosk
            $table->string('kiosk_id')->unique();

            // Associations with existing application records
            $table->foreignId('store_id')
                ->constrained('stores')
                ->restrictOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Latest observed kiosk information
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamp('logged_in_at')->nullable();
            $table->timestamp('logged_out_at')->nullable();

            $table->timestamps();

            $table->index('last_seen_at');
            $table->index(['store_id', 'last_seen_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kiosk_statuses');
    }
};
