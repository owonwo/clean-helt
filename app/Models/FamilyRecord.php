<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyRecord extends Model
{
    //
    public $fillable = ['disease', 'carriers'];
    public function record()
    {
        return $this->belongsTo(MedicalRecord::class, 'record_id');
    }
}
