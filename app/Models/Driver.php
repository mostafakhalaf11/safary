<?php

namespace App\Models;


class Driver extends BaseModel
{

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
