<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $casts = [
        'deadline' => 'datetime',
        'is_done' => 'boolean'
    ];

    protected $guarded = [];

    public function users() {
        return $this->belongsToMany(User::class);
    }
}
