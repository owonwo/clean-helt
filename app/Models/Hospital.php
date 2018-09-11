<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Traits\CodeGenerator;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class Hospital extends Authenticatable
{
    use Notifiable, CodeGenerator, HasMultiAuthApiTokens;

    protected $guarded = [];

    protected $hidden = ['password'];

    protected $codePrefix = 'CHH';

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


    /**
     * Checks whether a hospital can view a patient's profile
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

    /** Doctors */

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class);
    }

    public function scopePendingDoctors($query)
    {
        return $this->doctors()
            ->wherePivot('status','=', "0")
            ->wherePivot('actor', '!=', get_class($this));
    }

    public function scopeSentDoctors($query)
    {
        return $this->doctors()
            ->wherePivot('status','=', "0")
            ->wherePivot('actor', '=', get_class($this));
    }

    public function scopeActiveDoctors($query)
    {
        return $this->doctors()->wherePivot('status', "1");
    }

    public function isActiveDoctor(Doctor $doctor)
    {
        return $this->activeDoctors()
                ->where('doctor_id', $doctor->id)
                ->first() != null;
    }

    public function acceptDoctor(Doctor $doctor)
    {
        return $this->doctors()->wherePivot('doctor_id', $doctor->id)
            ->updateExistingPivot($doctor->id, ['status' => "1"]);
    }

    public function declineDoctor(Doctor $doctor)
    {
        return $this->doctors()->wherePivot('doctor_id', $doctor->id)
            ->updateExistingPivot($doctor->id, ['status' => "2"]);
    }
}
