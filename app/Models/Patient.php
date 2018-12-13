<?php

namespace App\Models;

use App\Notifications\PatientResetPasswordNotification;
use App\Traits\CodeGenerator;
use App\Traits\Utilities;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;
use Storage;

class Patient extends Authenticatable
{
    use HasMultiAuthApiTokens, CodeGenerator, Notifiable, Utilities;

    protected $codePrefix = 'CHP';

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

        if ($type) {
            $records = $records->where('type', $type);
        }

        return $records;
    }
    //Patient Immunization Records
    public function immunizationRecord()
    {
        return $this->hasMany(Immunization::class, 'record_id');
    }
    public function children()
    {
        return $this->hasMany(LinkedAccounts::class, 'patient_id');
    }

    public function laboratoryRecords()
    {
        return $this->hasMany(LabTest::class, 'record_id');
    }

    public function pharmacyRecords()
    {
        return $this->hasMany(Prescription::class, 'record_id');
    }

    public function contacts()
    {
        return $this->morphMany(Contact::class, 'owner');
    }

    public function ownsContact($chcode)
    {
        $modelClass = $this->getProvider($chcode);

        if ($modelClass && $model = $modelClass::whereChcode($chcode)->first()) {
            return $this->contacts()->where('contact_type', $modelClass)
                ->where('contact_id', $model->id)
                ->first();
        }

        return null;
    }

    public function getAvatarAttribute($avatar)
    {
        return asset(Storage::url($avatar));
    }

    public function hasChild($child)
    {
        $id = ($child instanceof Patient) ? $child->id : $child;

        return LinkedAccounts::where(['patient_id' => $this->id, 'child_id' => $id])->count('*') > 0;
    }
    /**
     * Unlinks a child from patient
     *
     * @param int|App\Models\Patient $child - The id of the child
     *
     * @return Boolean
     * @author Joseph Owonvwon
     **/
    public function unlinkChild($child)
    {
        $patient_id = $this->id;
        $child_id = ($child instanceof Patient) ? $child->id : $child;

        return DB::table('linked_accounts')->where(compact('child_id', 'patient_id'))->delete();
    }
}
