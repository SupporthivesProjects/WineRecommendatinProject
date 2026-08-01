<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subadmin_feature_permissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sub_admin_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('feature_id')
                ->constrained('subadmin_features')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['sub_admin_id', 'feature_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subadmin_feature_permissions');
    }
};