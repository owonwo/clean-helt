<?php

namespace App\Models;

use App\Traits\CodeGenerator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class Pharmacy extends Authenticatable
{
    use Notifiable, CodeGenerator, HasMultiAuthApiTokens;

    protected $codePrefix = 'CHF';

    protected $guarded = [];

    protected $hidden = ['password'];

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->chcode = $model->generateUniqueCode();
        });
    }

    public function getRouteKeyName()
    {
        return 'chcode';
    }

    /**
     * Checks whether a pharmacy can view a patient's profile
     * @param Patient $patient
     * @return bool
     */
    public function canViewProfile(Patient $patient)
    {
        return $this->profileShares()
                ->activeShares()
                ->acceptedShares()
                ->where('patient_id', $patient->id)
                ->first() !== null;
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

    public function issuer()
    {
        return $this->morphMany(MedicalRecord::class,'issuer');
    }

    public function canUpdatePatientPrescription(Patient $patient, MedicalRecord $medicalRecord, Prescription $prescription)
    {
        return $this->canViewProfile($patient) &&
            $medicalRecord->exists &&
            $prescription->exists &&
            $prescription->record_id == $medicalRecord->id;
    }
}
