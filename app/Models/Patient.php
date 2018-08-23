<?php

namespace App\Models;

use App\Notifications\PatientResetPasswordNotification;
use App\Traits\CodeGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Patient extends Authenticatable
{
    use HasApiTokens, CodeGenerator,Notifiable;

    protected $codePrefix = 'CHP';

    protected $guarded = [];

    protected $hidden = ['password'];

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model) {
            $model->chcode = $model->generateUniqueCode();
        });
    }
    
    public function getRouteKeyName()
    {
        return 'chcode';
    }

    public function profileShares()
    {
        return $this->hasMany(ProfileShare::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PatientResetPasswordNotification($token));
    }

    public function medicalRecords($type = null)
    {
        $records = $this->hasMany(MedicalRecord::class);

        if ($type)
            $records = $records->where('type', $type);

        return $records;
    }

    public function laboratoryRecords()
    {
        return $this->hasMany(LabTest::class, 'record_id');
    }

    public function pharmacyRecords()
    {
        return $this->hasMany(Prescription::class, 'record_id');
    }
}
