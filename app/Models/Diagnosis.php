<?php

namespace App\Models;

use App\Helpers\RecordLogger;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{


    protected $guarded = [];

    // Diagnosis Belongs to A patient
    public function record()
    {
        return $this->belongsTo(MedicalRecord::class, 'record_id');
    }
    //Diagnosis Belongs to patient
    public function getPatientAttribute(){
        return $this->record->patient;
    }

}
