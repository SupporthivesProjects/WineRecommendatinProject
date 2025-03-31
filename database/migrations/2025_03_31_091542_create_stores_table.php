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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('business_type')->nullable();
            $table->string('store_name');
            $table->text('address')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->string('state')->nullable();
            $table->string('licence_type')->nullable();
            $table->string('license_number')->nullable();
            $table->string('group')->nullable();
            $table->string('gst_vat')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
