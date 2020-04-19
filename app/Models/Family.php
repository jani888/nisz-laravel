<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Family extends Model {

    protected $guarded = [];

    public $incrementing = false;

    protected static function booted() {
        static::saving(function ($family) {
            if($family->chat_id == null) {
                $chat = \Chat::createConversation([]);
                $family->users->each(function ($user) use ($chat){
                    $chat->addParticipant($user);
                });
                $chat->update(['data' => ['title' => $family->name . ' család']]);

                $family->chat_id = $chat->id;
                return $family;
            }
        });
    }

    protected $appends = ["distance"];

    public function friends() {
        return $this->belongsToMany(Family::class, 'family_family', 'family1_id', 'family2_id');
    }

    public function scopeOrderByDistance(Builder $builder, Family $family) {
        return $builder->orderByRaw("( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) ", [
            $family->latitude,
            $family->longitude,
            $family->latitude,
        ]);
    }

    public function getDistanceAttribute() {
        return $this->distanceTo(request()->user()->family);
    }

    public function distanceTo(Family $other) {
        if (($this->latitude == $other->latitude) && ($this->longitude == $other->longitude)) {
            return 0;
        } else {
            $theta = $this->longitude - $other->longitude;
            $dist = sin(deg2rad($this->latitude)) * sin(deg2rad($other->latitude)) + cos(deg2rad($this->latitude)) * cos(deg2rad($other->latitude)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            return $miles * 1.609344;
        }
    }

    public function users() {
        return $this->hasMany(User::class);
    }

    public function schedule() {
        return $this->hasMany(Schedule::class);
    }
}
