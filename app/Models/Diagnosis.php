<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    protected $guarded = [];

    public function record()
    {
        return $this->belongsTo(MedicalRecord::class, 'record_id');
    }
}
