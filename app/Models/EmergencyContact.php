<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    //
    protected $guarded = [];

    protected $fillable = ['name', 'phone_2', 'phone', 'zip_code', 'address'];

    public function record()
    {
        return $this->belongsTo(MedicalRecord::class, 'record_id');
    }
}
