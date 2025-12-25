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
        Schema::create('trip_stops', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('trip_id');
            $table->string('name');
            $table->decimal('lat', 10, 7);
            $table->decimal('lng', 10, 7);
            $table->string('address');
            $table->unsignedInteger('stop_order');
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('trip_id')->references('id')->on('trips')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_stops');
    }
};
