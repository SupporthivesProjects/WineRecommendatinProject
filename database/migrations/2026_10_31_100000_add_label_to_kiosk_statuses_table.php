<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Optional readable name for a kiosk (e.g. "Entrance tablet"); existing rows stay NULL
        Schema::table('kiosk_statuses', function (Blueprint $table) {
            $table->string('label', 100)->nullable()->after('kiosk_id');
        });
    }

    public function down(): void
    {
        Schema::table('kiosk_statuses', function (Blueprint $table) {
            $table->dropColumn('label');
        });
    }
};
