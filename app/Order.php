<?php

namespace App;

use App\Classes\PaymentSystem;
use App\Events\OrderPaid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\QueriesRelationships;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Order extends Model
{
	use SearchableTrait;

	protected $searchable = [
		/**
		 * Columns and their priority in search results.
		 * Columns with higher values are more important.
		 * Columns with equal values have equal importance.
		 *
		 * @var array
		 */
		'columns' => [
			'orders.id'             => 30,
			'orders.reference'      => 30,
			'orders.duration'       => 20,
			'orders.paid'           => 10,
			'orders.canceled'       => 10,
			'orders.auto_activates' => 10,
			'users.email'           => 30,
			'users.steamid'         => 20,
			'users.username'        => 20,
			'users.name'            => 20,
			'users.tradelink'       => 10,
			'users.admin'           => 10,
		],
		'joins'   => [
			'users' => ['orders.user_id', 'users.id'],
		],
	];

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

	public $incrementing = false;

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
		$paymentSystem = new PaymentSystem();

		$this->recheck_attempts = $this->recheck_attempts + 1;

		$this->touch();
		$this->save();

		if (!$this->reference)
			return;

		$payment = $paymentSystem->getOrder($this->reference);

		if (!in_array($payment->status, [200, 201]))
			return;

		$payment = $payment->content;

		if (!isset($payment))
			return;

		if ($payment->paid_units)
			$this->duration = $payment->paid_units;

		if ($payment->paid)
			$this->paid = true;

		if (!$this->getOriginal('paid') && $this->paid)
			event(new OrderPaid($this));

		$this->touch();
		$this->save();
	}
}
