<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Laboratory extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $hidden = ['password'];
}
