<?php

namespace App\Models;


class Delivery extends BaseModel
{

    protected $fillable = [
        'booking_id',
        'rider_id',
        'driver_id',
        'description',
        'pickup_address',
        'pickup_lat',
        'pickup_lng',
        'dropoff_address',
        'dropoff_lat',
        'dropoff_lng',
        'item_size',
        'fee_offer',
        'status',
        'created_by',
        'updated_by',
    ];
}
