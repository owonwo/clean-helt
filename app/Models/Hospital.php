<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Traits\CodeGenerator;

class Hospital extends Authenticatable
{
    use Notifiable, HasApiTokens, CodeGenerator;

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

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class);
    }

    public function scopePendingDoctors($query)
    {
        return $this->doctors()
            ->wherePivot('status','=', 0)
            ->wherePivot('actor', '!=', get_class($this));
    }

    public function scopeSentDoctors($query)
    {
        return $this->doctors()
            ->wherePivot('status','=', 0)
            ->wherePivot('actor', '=', get_class($this));
    }

    public function scopeActiveDoctors($query)
    {
        return $this->doctors()->wherePivot('status', 1);
    }

    public function acceptDoctor(Doctor $doctor)
    {
        return $this->doctors()->wherePivot('doctor_id', $doctor->id)
            ->updateExistingPivot($doctor->id, ['status' => 1]);
    }

    public function declineDoctor(Doctor $doctor)
    {
        return $this->doctors()->wherePivot('doctor_id', $doctor->id)
            ->updateExistingPivot($doctor->id, ['status' => 2]);
    }
}
