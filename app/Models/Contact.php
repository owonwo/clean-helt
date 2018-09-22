<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [];

    public function owner()
    {
        return $this->morphTo();
    }

    public function contact()
    {
        return $this->morphTo();
    }
}
