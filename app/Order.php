<?php

namespace App;

use App\Classes\PaymentSystem;
use App\Events\OrderPaid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

/**
 * @property string  reference
 * @property integer duration
 * @property integer recheck_attempts
 * @property boolean auto_activates
 * @property Carbon  created_at
 * @property Carbon  updated_at
 * @property Carbon  starts_at
 * @property Carbon  ends_at
 * @property string  id
 */
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
			'orders.id'            => 30,
			'orders.reference'     => 30,
			'orders.duration'      => 20,
			'orders.paid'          => 10,
			'orders.canceled'      => 10,
			'orders.uploaded'      => 10,
			'orders.auto_activate' => 10,
			'users.email'          => 30,
			'users.steamid'        => 20,
			'users.username'       => 20,
			'users.name'           => 20,
			'users.tradelink'      => 10,
			'users.admin'          => 10,
		],
		'joins'   => [
			'users' => ['orders.user_id', 'users.id'],
		],
	];

	protected $fillable = ['duration', 'starts_at', 'ends_at', 'user_id', 'paid', 'canceled'];

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

	public function activate()
	{
		$now = Carbon::now();

		$this->starts_at = $now;
		$this->ends_at = $now->clone()->addDays($this->duration);
	}

	public function recheck()
	{
		$paymentSystem = new PaymentSystem();

		$this->recheck_attempts = $this->recheck_attempts + 1;

		if ($this->reference)
			$payment = $paymentSystem->getOrder($this->reference);

		// TODO: what happens when this order is manually set to paid? How to recheck? Activated?
		if ($this->paid || (isset($payment) && $payment->paid)) {
			$this->paid = true;
			event(new OrderPaid($this));
		}

		$this->touch();
		$this->save();
	}
}
