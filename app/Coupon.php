<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code', 'discount', 'starts_at', 'ends_at'];

    protected $dates = ['starts_at', 'ends_at'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeValid(Builder $query)
    {
        return $query
            ->where('order_id', '=', null)
            ->where('starts_at', '<', now())
            ->where('ends_at', '>', now());
    }

    public function getExpiredAttribute()
    {
        return $this->ends_at->isPast();
    }

    public function getStartedAttribute()
    {
        return $this->starts_at->isPast();
    }
}
