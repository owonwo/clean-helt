<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class DoctorProfile extends Model
{
    //
    protected $fillable = ['active'];

    public function getAvatarAttribute($avatar)
    {
        return asset(Storage::url($avatar));
    }
}
