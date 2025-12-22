<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'driver_id',
        'user_id',
        'title',
        'start_lat',
        'start_lng',
        'start_address',
        'end_lat',
        'end_lng',
        'end_address',
        'start_time',
        'end_time',
        'total_seats',
        'available_seats',
        'price_per_seat',
        'allow_custom_dropoff',
        'allow_pickup_from_user',
        'geofence_radius_start',
        'geofence_radius_end',
        'status',
        'created_by',
        'updated_by',
    ];
    protected $casts = [
        'allow_custom_dropoff' => 'boolean',
        'allow_pickup_from_user' => 'boolean',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
}
