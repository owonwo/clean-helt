<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class MedicalCheckup extends Model
{
    protected $guarded = [];
    
    public function record()
    {
        return $this->belongsTo(MedicalRecord::class, 'record_id');
    }
    
    public function getReportAttribute($report)
    {
        return asset(Storage::url($report));
    }
}
