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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relations
            $table->uuid('rider_id');
            $table->uuid('driver_id')->nullable();

            // Details
            $table->text('description');

            // Pickup
            $table->string('pickup_address');
            $table->decimal('pickup_lat', 10, 7);
            $table->decimal('pickup_lng', 10, 7);

            // Dropoff
            $table->string('dropoff_address');
            $table->decimal('dropoff_lat', 10, 7);
            $table->decimal('dropoff_lng', 10, 7);

            // Item and pricing
            $table->enum('item_size', ['small', 'medium', 'large']);
            $table->decimal('fee_offer', 10, 2);

            // Status
            $table->enum('status', ['requested', 'accepted', 'picked_up', 'delivered', 'cancelled'])->default('requested');

            $table->uuid('created_by');
            $table->uuid('updated_by');
            $table->timestamps();

            // Helpful indexes
            $table->index(['rider_id', 'driver_id']);
            $table->index('status');

            // Foreign keys
            $table->foreign('rider_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('driver_id')->references('id')->on('drivers')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
