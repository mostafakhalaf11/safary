<?php

namespace App\Models;

class TripStop extends BaseModel
{
    protected $fillable = [
        'trip_id',
        'name',
        'lat',
        'lng',
        'address',
        'stop_order',
        'created_by',
        'updated_by',
    ];
}
