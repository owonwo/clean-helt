<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ProfileShare extends Model
{
    use Notifiable;

    protected $guarded = [];

    protected $fillable = ['status', 'provider_id', 'doctor_id', 'referral_status','provider_type','expired_at'];

    protected $dates = ['expired_at'];

    protected $with = ['patient'];

    /**
     * A profile share belongs to a patient
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * A profile share has many extensions
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function extensions()
    {
        return $this->hasMany(ShareExtension::class, 'share_id');
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

    public function getHoursAttribute()
    {
        return $this->expired_at->diffInHours($this->created_At);
    }

    public function scopeActiveShares($query)
    {
        return $query->whereDate('expired_at', '>=', now());
    }

    public function scopeFilter($query, $filter)
    {
        return $filter->apply($query);
    }

    public function scopeAcceptedShares($query)
    {
        return $query->where('status', '1');
    }

    public function scopePendingShares($query)
    {
        return $query->where('status', '0');
    }
}
