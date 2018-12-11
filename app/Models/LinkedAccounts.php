<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkedAccounts extends Model
{
    //
    public function account(){
        return $this->belongsTo(Patient::class,'child_id');
    }
}
