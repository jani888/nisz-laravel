<?php

namespace App;

use App\Models\Family;
use App\Models\Todo;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Musonza\Chat\Traits\Messageable;

class User extends Authenticatable
{
    use Notifiable, Messageable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'family_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted() {
        static::saved(function ($user) {
            if($user->family_id){
                \Chat::conversations()->getById(Family::find($user->family_id)->chat_id)->addParticipants([$user]);
            }
        });
    }


    public function family() {
        return $this->belongsTo(Family::class);
    }

    public function todos() {
        return $this->belongsToMany(Todo::class);
    }
}
