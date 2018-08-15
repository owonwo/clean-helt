<?php

namespace App\Models;

use App\Traits\CodeGenerator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Pharmacy extends Authenticatable
{
    use Notifiable, HasApiTokens, CodeGenerator;

    protected $codePrefix = 'CHF';

    protected $guarded = [];

    protected $hidden = ['password'];

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->chcode = $model->generateUniqueCode();
        });
    }

    public function getRouteKeyName()
    {
        return 'chcode';
    }
    public function issuer(){
        return $this->morphMany('App\Models\MedicalRecord','issuer');
    }
}
