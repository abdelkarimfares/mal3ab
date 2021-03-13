<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'adress1',
        'adress2',
        'gender',
        'city',
        'account_status',
        'status_date',
        'package',
    ];
}
