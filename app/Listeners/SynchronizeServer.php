<?php

namespace App\Listeners;

use App\Order;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class SynchronizeServer implements ShouldQueue
{
	use InteractsWithQueue;

	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  object $event
	 *
	 * @return void
	 */
	public function handle($event)
	{
		$pendingOrders = Order::query()->where('paid', true)->where('canceled', false)->where('ends_at', '>', Carbon::now())->get();

		$this->updateOrders($pendingOrders);
	}

	private function updateOrders($pendingOrders)
	{
		// Map SteamID => Username to remove duplicates
		$orders = $pendingOrders->mapWithKeys(function ($order) {
			return [$order->user->steamid => $order->user->username];
		});

		// Query current orders in database
		$existing = DB::connection('sm_admins')->table('sm_admins')->select('identity')->get()->unique('identity');

		// Figure out what orders are missing from database
		$pendingOrders = $orders->reject(function ($username, $id) use ($existing) {
			return $existing->contains('identity', $id);
		});

		// Figure out what orders should not be in the database
		$expiredOrders = $existing->reject(function ($id) use ($orders) {
			return $orders->has($id->identity);
		});

		// Insert order into database
		foreach ($pendingOrders as $steamid => $username) {
			DB::connection('sm_admins')->table('sm_admins')->insert([
				'authtype' => 'steam',
				'identity' => $steamid,
				'name'     => $username,
				'flags'    => 'a',
				'immunity' => 50,
			]);
		}

		// Delete expires orders
		foreach ($expiredOrders as $id) {
			DB::connection('sm_admins')->table('sm_admins')->where('identity', $id->identity)->delete();
		}
	}
}
