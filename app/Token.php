<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Token extends Model
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
			'tokens.id'        => 30,
			'tokens.duration'  => 20,
			'tokens.note'      => 30,
			'orders.id'        => 30,
			'orders.reference' => 30,
			'orders.duration'  => 20,
			'users.email'      => 30,
			'users.steamid'    => 20,
			'users.username'   => 20,
			'users.name'       => 20,
			'users.tradelink'  => 10,
			'users.admin'      => 10,
		],
		'joins'   => [
			'users'  => ['tokens.user_id', 'users.id'],
			'orders' => ['tokens.order_id', 'orders.id'],
		],
	];

	protected $fillable = ['id', 'duration', 'note', 'expires_at'];

	protected $dates = ['expires_at'];

	protected $with = ['user'];

	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
		'expires_at' => 'datetime',
	];

	public $incrementing = false;

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function order()
	{
		return $this->belongsTo(Order::class);
	}
}
