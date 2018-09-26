<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Storage;

class Admin extends Authenticatable
{
    use HasApiTokens,Notifiable;

    protected $guarded = [];

    protected $hidden = ['password'];

    public function getAvatarAttribute($avatar)
    {
        return asset(Storage::url($avatar));
    }
}
