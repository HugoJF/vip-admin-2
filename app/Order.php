<?php

namespace App;

use App\Classes\PaymentSystem;
use App\Events\OrderPaid;
use App\Services\OrderRecheckService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Order extends Model implements Searchable
{
    public $incrementing = false;
    protected $fillable = ['duration', 'starts_at', 'ends_at', 'user_id', 'paid', 'canceled', 'steamid'];
    protected $with = ['user'];
    protected $casts = [
        'created_at'     => 'datetime',
        'updated_at'     => 'datetime',
        'starts_at'      => 'datetime',
        'ends_at'        => 'datetime',
        'paid'           => 'boolean',
        'auto_activates' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function token()
    {
        return $this->hasOne(Token::class);
    }

    public function reason()
    {
        return $this->morphOne(Token::class, 'reason');
    }

    public function coupon()
    {
        return $this->hasOne(Coupon::class);
    }

    public function getActivatedAttribute()
    {
        return $this->starts_at && $this->ends_at;
    }

    public function getExpiredAttribute()
    {
        return $this->ends_at && $this->ends_at->isPast();
    }

    public function getRemainingAttribute()
    {
        if (!$this->starts_at || !$this->ends_at || $this->ends_at->isPast()) {
            return null;
        }

        // If Order has not started, then compute the exact period remaining (essentially the duration).
        // If Order has started, then compute the actual remaining period, and +1 because 23h59 = 0 days
        if ($this->starts_at->isFuture()) {
            return $this->ends_at->diffInDays($this->starts_at);
        } else {
            return $this->ends_at->diffInDays(now()) + 1;
        }
    }

    public function scopePaid(Builder $query)
    {
        return $query->wherePaid(true);
    }

    public function scopeValid(Builder $query)
    {
        return $query->whereCanceled(false);
    }

    public function scopeStarted(Builder $query)
    {
        return $query->where('starts_at', '<=', now());
    }

    public function scopeNotExpired(Builder $query)
    {
        return $query->where('ends_at', '>=', now());
    }

    public function scopeNotTransferred(Builder $query)
    {
        return $query->whereNull('steamid');
    }

    public function scopeTransferred(Builder $query)
    {
        return $query->whereNotNull('steamid');
    }

    public function scopeExpired(Builder $query)
    {
        return $query->where('ends_at', '<', now());
    }

    public function scopeSynced(Builder $query)
    {
        return $query->whereNotNull('synced_at');
    }

    public function scopeUnsynced(Builder $query)
    {
        return $query->whereNull('synced_at');
    }

    public function scopePending(Builder $query)
    {
        return $query
            ->paid()
            ->valid()
            ->started()
            ->notExpired()
            ->unsynced();
    }

    public function scopeActive(Builder $query)
    {
        return $query
            ->paid()
            ->valid()
            ->started()
            ->notExpired()
            ->synced();
    }

    public function recheck()
    {
        /** @var OrderRecheckService $service */
        $service = app(OrderRecheckService::class);

        $service->handle($this);
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->id,
            route('orders.show', $this)
        );
    }
}
