<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileShare extends Model
{
    protected $guarded = [];

    protected $dates = ['expired_at'];

    /**
     * A profile share belongs to a patient
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * A profile share belongs to a service provider
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    
    public function provider()
    {
        return $this->morphTo();
    }

    // Creates an active attribute for the profile share
    public function getIsActiveAttribute()
    {
        return $this->expired_at->gt(now());
    }
    public function getHoursAttribute(){
        return $this->expired_at->diffInHours($this->created_At);
    }
    public function scopeActiveShares($query)
    {
        return $query->whereDate('expired_at', '>=', now());
    }
    public function scopeFilter($query,$filter){
        return $filter->apply($query);
    }
    public function scopeAcceptedShares($query)
    {
        return $query->where('status', 1);
    }
}
