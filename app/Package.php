<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    //
    protected $fillable = [
        'geolocation', 'address', 'price', 'user_id'
    ];

    protected $casts = [
        'geolocation' => 'json'
    ];
}
