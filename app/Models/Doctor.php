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
    protected $casts = [
        'confirm' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->chcode = $model->generateUniqueCode();
        });
        self::created(function ($model){
           DoctorProfile::forceCreate([
               'doctors_id' => $model->id
           ]);
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

    public function allShares()
    {
        return $this->profileShares()->orWhere('doctor_id', $this->id);
    }

    /**
     * Checks whether a doctor can view a patient's profile
     * @param Patient $patient
     * @return bool
     */
    public function canViewProfile(Patient $patient)
    {
        return $this->profileShares()
                ->activeShares()
                ->where('patient_id', $patient->id)
                ->first() !== null;
    }

    public function confirm(){
        $this->confirm = true;
        $this->token = null;
        $this->save();
    }
    public function profile()
    {
        return $this->hasOne(DoctorProfile::class,'doctors_id');
    }
}
