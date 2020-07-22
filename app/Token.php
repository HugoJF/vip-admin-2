<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    public $incrementing = false;
    protected $fillable = ['id', 'duration', 'note', 'expires_at'];
    protected $dates = ['expires_at'];
    protected $with = ['user'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function reason()
    {
        return $this->morphTo();
    }

    public function getUsedAttribute()
    {
        return $this->order !== null;
    }

    public function getExpiredAttribute()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }
}
