<?php

namespace App\Models;

use App\Traits\CodeGenerator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Doctor extends Authenticatable
{
    use HasApiTokens, CodeGenerator;

    protected $codePrefix = 'CHD';

    protected $guarded = [];

    protected $hidden = ['password'];

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model) {
            $model->chcode = $model->generateUniqueCode();
        });
    }
}
