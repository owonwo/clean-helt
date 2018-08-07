<?php

namespace App\Models;

use App\Traits\CodeGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Patient extends Authenticatable
{
    use HasApiTokens, CodeGenerator;

    protected $codePrefix = 'CHP';

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
