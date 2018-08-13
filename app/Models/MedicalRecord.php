<?php

namespace App\Models;

use App\Traits\CodeGenerator;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use CodeGenerator;

    protected $guarded = [];

    protected $codePrefix = 'CHR';

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->reference = $model->generateUniqueCode(null, 'reference');
        });
    }

    // A medical Record Belong to a patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function issuer()
    {
        return $this->morphTo();
    }

}
