<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->uuid('booking_id')
                ->nullable()
                ->after('driver_id');

            $table->foreign('booking_id')->references('id')->on('bookings')->nullOnDelete();
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->uuid('delivery_request_id')
                ->nullable()
                ->after('cancel_reason');

            $table->foreign('delivery_request_id')->references('id')->on('deliveries')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->dropForeign(['booking_id']);
            $table->dropColumn('booking_id');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['delivery_request_id']);
            $table->dropColumn('delivery_request_id');
        });
    }
};
