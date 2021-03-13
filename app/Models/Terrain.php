<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terrain extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'length',
        'width',
        'floor_type',
        'city',
        'adress',
        'google_latitude',
        'google_attitude',
        'has_arbite',
        'type_terrain_id',
        'account_id',
        'thumbnail_id',
        'gallary',
    ];
}
