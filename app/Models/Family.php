<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    protected $guarded = [];

    public $incrementing = false;

    public function users() {
        return $this->hasMany(User::class);
    }

    public function schedule() {
        return $this->hasMany(Schedule::class);
    }
}
