<?php

namespace App\Models;

use App\Models\LabTest;
use App\Models\MedicalRecord;
use App\Traits\CodeGenerator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Notifications\LaboratoryResetPasswordNotification;

class Laboratory extends Authenticatable
{
    use Notifiable, HasApiTokens, CodeGenerator;

    protected $codePrefix = 'CHL';
    
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

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new LaboratoryResetPasswordNotification($token));
    }

    public function profileShares()
    {
        return $this->morphMany(ProfileShare::class, 'provider');
    }

    public function scopePatients($query)
    {
        return $this->profileShares()
            ->acceptedShares()
            ->activeShares()
            ->with('patient');
    }

    public function scopePendingShares($query)
    {
        return $this->profileShares()
            ->pendingShares()
            ->activeShares()
            ->with('patient');
    }

    public function ownsShare(ProfileShare $share)
    {
        return $this->chcode === $share->provider->chcode;
    }


    public function canViewProfile(Patient $patient)
    {
        return $this->profileShares()
                ->activeShares()
                ->where('patient_id', $patient->id)
                ->first() !== null;
    }

    public function issuer()
    {
        return $this->morphMany(MedicalRecord::class, 'issuer');
    }



    public function canUpdatePatientPrescription(Patient $patient, MedicalRecord $medicalRecord,LabTest $labTest)
    {
        return $this->canViewProfile($patient) &&
            $medicalRecord->exists &&
            $labTest->exists &&
            $labTest->record_id == $medicalRecord->id;
    }


}