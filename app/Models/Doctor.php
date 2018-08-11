<?php

namespace App\Models;

use App\Traits\CodeGenerator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Doctor extends Authenticatable
{
    use HasApiTokens, CodeGenerator,Notifiable;

    protected $codePrefix = 'CHD';

    protected $guarded = [];

    protected $hidden = ['password'];

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->chcode = $model->generateUniqueCode();
        });
    }

    public function profileShares()
    {
        return $this->morphMany(ProfileShare::class, 'provider');
    }

    /**
     * Checks whether a doctor can view a patient's profile
     * @param Patient $patient
     * @return bool
     */
    public function canViewProfile(Patient $patient)
    {
        return $this->profileShares()
            ->where('patient_id', $patient->id)
            ->whereDate('expired_at', '>=', now())
            ->first() !== null;
    }

    public function profile()
    {
        return $this->hasOne(DoctorProfile::class,'doctors_id');
    }
}
