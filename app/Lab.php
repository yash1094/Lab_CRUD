<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Lab extends Model
{

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }


    //casting the timestamp to a date time format
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];
}
