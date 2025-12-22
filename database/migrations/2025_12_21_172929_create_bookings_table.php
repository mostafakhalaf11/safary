<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('trip_id')->constrained('trips')->cascadeOnDelete();
            $table->foreignId('rider_id')->constrained('users')->cascadeOnDelete();

            // Pickup details
            $table->enum('pickup_type', ['stop', 'custom_location']);
            $table->foreignId('pickup_stop_id')->nullable()->constrained('trip_stops')->nullOnDelete();
            $table->decimal('pickup_lat', 10, 7)->nullable();
            $table->decimal('pickup_lng', 10, 7)->nullable();

            // Dropoff details
            $table->enum('dropoff_type', ['stop', 'custom_location']);
            $table->foreignId('dropoff_stop_id')->nullable()->constrained('trip_stops')->nullOnDelete();
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
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('updated_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            // Helpful indexes (foreignId already indexes, but explicit is fine)
            $table->index(['trip_id', 'rider_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
