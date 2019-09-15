<?php

namespace App\Console\Commands;

use App\Order;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Query\Processors\MySqlProcessor;
use Illuminate\Support\Facades\DB;

class ImportOldData extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'vipadmin:import';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$data = DB::connection('vip_admin_1')
				  ->table('confirmations')
				  ->whereNull('confirmations.deleted_at')
				  ->leftJoin('orders', 'confirmations.order_id', '=', 'orders.id')
				  ->leftJoin('users', 'confirmations.user_id', '=', 'users.id')
				  ->select([
					  'orders.public_id',
					  'orders.duration',
					  'orders.created_at',
					  'orders.updated_at',
					  'confirmations.start_period',
					  'confirmations.end_period',
					  'users.steamid',
					  'users.avatar',
					  'users.username',
					  'users.tradelink',
					  'users.email',
				  ])
				  ->get();

		foreach ($data as $confirmation) {
			$this->addOrder($confirmation);
		}
	}

	private function addOrder($confirmation)
	{
		$order = Order::make();

		$maxTimestamp = Carbon::parse('2030-01-01 00:00:00');
		$startsAt = Carbon::parse($confirmation->start_period, 'utc')->tz(-4);
		$endsAt = Carbon::parse($confirmation->end_period, 'utc')->tz(-4);
		if ($endsAt->diff($maxTimestamp)->invert)
			$endsAt = $maxTimestamp;
		if ($startsAt->diff($maxTimestamp)->invert)
			$startsAt = $maxTimestamp;

		$order->id = $confirmation->public_id;
		$order->duration = $endsAt->diffInDays($startsAt, true);
		$order->steamid = $confirmation->steamid;

		$order->starts_at = $startsAt;
		$order->ends_at = $endsAt;
		$order->synced_at = null;

		$order->steamid = null;
		$order->paid = true;

		$order->canceled = false;
		$order->reference = null;
		$order->init_point = null;
		$order->auto_activates = false;

		$order->created_at = Carbon::parse($confirmation->created_at, 'utc')->tz(-4);
		$order->updated_at = Carbon::parse($confirmation->updated_at, 'utc')->tz(-4);

		$order->user()->associate($this->firstOrCreateUser($confirmation));

		$order->save();
	}

	public function firstOrCreateUser($data)
	{
		$steamid = steamid64($data->steamid);

		$user = User::whereSteamid($steamid)->first();
		if ($user)
			return $user;

		/** @var User $user */
		$user = User::make();
		$user->steamid = $steamid;
		$user->username = $data->username;
		$user->avatar = $data->avatar;
		$user->tradelink = $data->tradelink;
		$user->email = $data->email;

		$user->save();

		return $user;
	}
}
