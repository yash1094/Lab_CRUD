<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{


    //casting the timestamp to a date time format
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];
}
