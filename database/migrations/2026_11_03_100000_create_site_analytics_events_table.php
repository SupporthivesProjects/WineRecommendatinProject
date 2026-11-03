<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Page views and link/button clicks of logged-in kiosk users, for the admin "Website Health" page
        Schema::create('site_analytics_events', function (Blueprint $table) {
            $table->id();
            $table->string('event', 20);                 // page_view or click
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('store_id')->nullable()->index();
            $table->string('route_name', 150)->nullable()->index();
            $table->string('path', 255);
            $table->string('label', 150)->nullable();    // clicks: the link or button text
            $table->string('target', 255)->nullable();   // clicks: where the link goes
            $table->unsignedBigInteger('product_id')->nullable()->index();
            $table->timestamp('created_at')->nullable();

            $table->index(['event', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_analytics_events');
    }
};
