<?php

namespace App\Models;

use App\Traits\CodeGenerator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Notifications\LaboratoryResetPasswordNotification;

class Laboratory extends Authenticatable
{
    use Notifiable, HasApiTokens, CodeGenerator;

    protected $codePrefix = 'CHL';
    
    protected $guarded = [];

    protected $hidden = ['password'];

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

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new LaboratoryResetPasswordNotification($token));
    }
}
