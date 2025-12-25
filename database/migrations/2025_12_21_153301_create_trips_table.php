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
        Schema::create('trips', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('driver_id');
            $table->uuid('user_id');
            $table->string('title');

            $table->decimal('start_lat', 10, 7);
            $table->decimal('start_lng', 10, 7);
            $table->string('start_address');

            $table->decimal('end_lat', 10, 7);
            $table->decimal('end_lng', 10, 7);
            $table->string('end_address');

            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();

            $table->unsignedInteger('total_seats');
            $table->unsignedInteger('available_seats')->nullable();
            $table->decimal('price_per_seat', 10, 2);
            $table->boolean('allow_custom_dropoff')->default(false);
            $table->boolean('allow_pickup_from_user')->default(false);
            $table->unsignedInteger('geofence_radius_start')->nullable();
            $table->unsignedInteger('geofence_radius_end')->nullable();
            $table->enum('status', ['draft', 'published', 'cancelled'])->default('draft');
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();

            $table->timestamps();

            $table->foreign('driver_id')->references('id')->on('drivers')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
