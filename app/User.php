<?php

namespace App;

use App\Alerts\AgreedToTerms;
use App\Alerts\MissingAffiliateCode;
use App\Alerts\MissingEmailAlert;
use App\Alerts\MissingTradeLinkAlert;
use App\Alerts\OrderPendingActivationAlert;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
	use Notifiable;
	use SearchableTrait;

	protected $searchable = [
		'columns' => [
			'users.steamid'        => 75,
			'users.email'          => 50,
			'users.affiliate_code' => 30,
			'users.name'           => 25,
			'users.username'       => 25,
			'users.tradelink'      => 10,
		],
	];

	protected $fillable = [
		'name',
		'tradelink',
		'email',
		'password',
		'username',
		'avatar',
		'terms',
		'affiliate_code',
	];

	protected $hidden = [
		'password', 'remember_token',
	];

	protected $casts = [
		'admin'             => 'boolean',
		'affiliate'         => 'boolean',
		'terms'             => 'boolean',
		'email_verified_at' => 'datetime',
		'created_at'        => 'datetime:c',
		'updated_at'        => 'datetime:c',
	];

	protected $alerts = [
		AgreedToTerms::class,
		MissingTradeLinkAlert::class,
		MissingEmailAlert::class,
		OrderPendingActivationAlert::class,
		MissingAffiliateCode::class,
	];

	public function tokens()
	{
		return $this->hasMany(Token::class);
	}

	public function orders()
	{
		return $this->hasMany(Order::class);
	}

	public function referrer()
	{
		return $this->belongsTo(User::class);
	}

	public function referees()
	{
		return $this->hasMany(User::class, 'referrer_id');
	}

	public function reason()
	{
		return $this->morphOne(Token::class, 'reason');
	}

	public function currentVip()
	{
		$paidOrders = $this->orders()
						   ->wherePaid(true)
						   ->whereNotNull('ends_at')
						   ->whereCanceled(false)
						   ->get();

		if ($paidOrders->count() === 0)
			return false;

		$durations = $paidOrders->map(function ($order) {
			// +1 because 23h = 0 days
			return $order->ends_at->diffInDays(Carbon::now()) + 1;
		});

		return $durations->max();
	}

	public function getAlerts()
	{
		$messages = [];

		foreach ($this->alerts as $alert) {
			$a = new $alert($this);

			if ($a->triggered())
				$messages[ $alert ] = [
					'message' => $a->getMessage(),
					'level'   => $a->getLevel(),
					'url'     => $a->getUrl(),
				];
		}

		return collect($messages);
	}

	/**
	 * Get the identifier that will be stored in the subject claim of the JWT.
	 *
	 * @return mixed
	 */
	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Return a key value array, containing any custom claims to be added to the JWT.
	 *
	 * @return array
	 */
	public function getJWTCustomClaims()
	{
		return [];
	}
}
