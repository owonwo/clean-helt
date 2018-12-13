<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkedAccounts extends Model
{
    //
    protected $fillable = ['child_id', 'patient_id'];

    public function account()
    {
        return $this->belongsTo(Patient::class, 'child_id');
    }
}
