<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Family extends Model {

    protected $guarded = [];

    public $incrementing = false;

    protected static function booted() {
        static::creating(function ($family) {
            $chat = \Chat::createConversation($family->users->toArray());
            $chat->update(['data' => ['title' => $family->name . ' család']]);

            $family->chat_id = $chat->id;
        });
    }

    public function users() {
        return $this->hasMany(User::class);
    }

    public function schedule() {
        return $this->hasMany(Schedule::class);
    }
}
