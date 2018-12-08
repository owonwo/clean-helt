<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalContacts extends Model
{
    //
    protected $guarded = [];

    public function record()
    {
        return $this->belongsTo(MedicalRecord::class, 'record_id');
    }
}
