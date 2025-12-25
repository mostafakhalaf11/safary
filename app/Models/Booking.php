<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends BaseModel
{

    protected $fillable = [
        'trip_id',
        'rider_id',
        'pickup_type',
        'pickup_stop_id',
        'pickup_lat',
        'pickup_lng',
        'dropoff_type',
        'dropoff_stop_id',
        'dropoff_lat',
        'dropoff_lng',
        'seats_booked',
        'price_total',
        'status',
        'cancel_reason',
        'delivery_request_id',
        'created_by',
        'updated_by',
    ];
}
