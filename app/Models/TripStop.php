<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripStop extends Model
{
    use HasFactory;
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
