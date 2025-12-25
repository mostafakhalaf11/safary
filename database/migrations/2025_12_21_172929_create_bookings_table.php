<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relations
            $table->uuid('trip_id');
            $table->uuid('rider_id');

            // Pickup details
            $table->enum('pickup_type', ['stop', 'custom_location']);
            $table->uuid('pickup_stop_id')->nullable();
            $table->decimal('pickup_lat', 10, 7)->nullable();
            $table->decimal('pickup_lng', 10, 7)->nullable();

            // Dropoff details
            $table->enum('dropoff_type', ['stop', 'custom_location']);
            $table->uuid('dropoff_stop_id')->nullable();
            $table->decimal('dropoff_lat', 10, 7)->nullable();
            $table->decimal('dropoff_lng', 10, 7)->nullable();

            // Booking details
            $table->unsignedInteger('seats_booked');
            $table->decimal('price_total', 10, 2);
            $table->enum('status', [
                'requested',
                'accepted',
                'rejected',
                'confirmed',
                'on_route',
                'completed',
                'cancelled',
            ])->default('requested');

            $table->text('cancel_reason')->nullable();
            $table->uuid('created_by');
            $table->uuid('updated_by');
            $table->timestamps();

            // Helpful indexes
            $table->index(['trip_id', 'rider_id']);

            // Foreign keys
            $table->foreign('trip_id')->references('id')->on('trips')->cascadeOnDelete();
            $table->foreign('rider_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('pickup_stop_id')->references('id')->on('trip_stops')->nullOnDelete();
            $table->foreign('dropoff_stop_id')->references('id')->on('trip_stops')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
