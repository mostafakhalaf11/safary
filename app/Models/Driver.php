<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vehicle_make',
        'vehicle_model',
        'vehicle_plate_number',
        'vehicle_color',
        'license_number',
        'license_doc_path',
        'status',
        'rating_avg',
        'created_by',
        'updated_by',
    ];
}
