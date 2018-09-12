<?php

namespace App\Models;

use App\Traits\CodeGenerator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class Doctor extends Authenticatable
{
    use CodeGenerator, Notifiable, HasMultiAuthApiTokens;

    protected $codePrefix = 'CHD';

    protected $guarded = ['deleted_at', 'created_at'];

    protected $hidden = ['password'];
    protected $with = ['profile'];

    protected $casts = [
        'confirm' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->chcode = $model->generateUniqueCode();
        });
        // self::created(function ($model){
        //    DoctorProfile::forceCreate([
        //        'doctors_id' => $model->id
        //    ]);
        // });
    }

    public function getRouteKeyName()
    {
        return 'chcode';
    }

    public function scopeFilter($query, $filter)
    {
        return $filter->apply($query);
    }

    public function profileShares()
    {
        return $this->morphMany(ProfileShare::class, 'provider');
    }

    public function allShares()
    {
        return $this->profileShares()->orWhere('doctor_id', $this->id);
    }

    /**
     * Checks whether a doctor can view a patient's profile.
     *
     * @param Patient $patient
     *
     * @return bool
     */
    public function canViewProfile(Patient $patient)
    {
        return null !== $this->profileShares()
                ->activeShares()
                ->where('patient_id', $patient->id)
                ->first();
    }

    public function confirm()
    {
        $this->confirm = true;
        $this->token = null;
        $this->save();
    }

    public function profile()
    {
        return $this->hasOne(DoctorProfile::class, 'doctors_id');
    }

    public function hospitals()
    {
        return $this->belongsToMany(Hospital::class);
    }

    public function acceptHospital(Hospital $hospital)
    {
        return $this->hospitals()->wherePivot('hospital_id', $hospital->id)
            ->updateExistingPivot($hospital->id, ['status' => '1']);
    }

    public function declineHospital(Hospital $hospital)
    {
        return $this->hospitals()->wherePivot('hospital_id', $hospital->id)
            ->updateExistingPivot($hospital->id, ['status' => 2]);
    }

    public function scopeActiveHospitals($query)
    {
        return $this->hospitals()->wherePivot('status', '1');
    }

    public function scopeSentHospitals($query)
    {
        return $this->hospitals()
            ->wherePivot('status', '=', 0)
            ->wherePivot('actor', '!=', get_class($this));
    }

    public function scopePendingHospitals($query)
    {
        return $this->hospitals()
            ->wherePivot('status', '=', 0)
            ->wherePivot('actor', '=', get_class($this));
    }

    public function isActiveHospital(Hospital $hospital)
    {
        return null != $this->activeHospitals()
                    ->where('hospital_id', $hospital->id)
                    ->first();
    }
}
