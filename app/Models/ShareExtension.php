<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShareExtension extends Model
{
    protected $guarded = [];
    
    // protected $with = ['provider'];
    
    public function provider()
    {
        return $this->morphTo();
    }
    
    public function sharer()
    {
        return $this->morphTo();
    }
    
    public function profileShare()
    {
        return $this->belongsTo(ProfileShare::class, 'share_id');
    }
    
    // Creates an active attribute for the share
    public function getIsActiveAttribute()
    {
        return $this->expired_at->gt(now());
    }
    
    public function scopeActiveShares($query)
    {
        return $query->whereDate('expired_at', '>=', now())->where('status', "1");
    }
}
