<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    //
    protected $guarded = [];

    public function record()
    {
        return $this->belongsTo(MedicalRecord::class, 'record_id');
    }
}
