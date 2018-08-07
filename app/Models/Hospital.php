<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Traits\CodeGenerator;

class Hospital extends Authenticatable
{
    use Notifiable, HasApiTokens, CodeGenerator;

    protected $guarded = [];

    protected $hidden = ['password'];

    protected $codePrefix = 'CHH';

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model) {
            $model->chcode = $model->generateUniqueCode();
        });
    }

    public function getRouteKeyName()
    {
        return 'chcode';
    }
}
