<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = [];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];
}
