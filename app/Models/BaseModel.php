<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BaseModel extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasUuids;
    /**
     * Use UUID primary keys (not auto-incrementing integers).
     */
    public $incrementing = false;

    /**
     * The data type of the primary key.
     */
    protected $keyType = 'string';
}
