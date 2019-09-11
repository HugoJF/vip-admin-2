<?php

namespace App\Listeners;

use App\Classes\SteamID;
use App\Events\OrderExpired;
use App\Events\OrderSynchronized;
use App\Order;
use App\User;
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
		// TODO: order asc by ends_at
		$pendingOrders = Order::query()
							  ->where('paid', true)
							  ->where('canceled', false)
							  ->where('starts_at', '<', Carbon::now())
							  ->where('ends_at', '>', Carbon::now())
							  ->get();

		$this->updateOrders($pendingOrders);
	}

	private function updateOrders($pendingOrders)
	{
		// Map SteamID => Username to remove duplicates
		$orders = $pendingOrders->mapWithKeys(function ($order) {
			if ($order->steamid)
				return [$this->toSteamId2($order->steamid) => $order];
			else
				return [$this->toSteamId2($order->user->steamid) => $order];
		});

		// Query current orders in database
		$existing = DB::connection('sm_admins')->table('sm_admins')->select('identity')->get()->unique('identity');

		// Figure out what orders are missing from database
		$pendingOrders = $orders->reject(function ($order, $id) use ($existing) {
			return $existing->contains('identity', $id);
		});

		// Since we store the actual order, map to steamid
		$orders = $orders->map(function ($order) {
			return $this->toSteamId2($order->user->steamid);
		});

		// Figure out what orders should not be in the database
		$expiredOrders = $existing->reject(function ($id) use ($orders) {
			return $orders->has($id->identity);
		});

		// Insert order into database
		foreach ($pendingOrders as $steamid => $order) {
			DB::connection('sm_admins')->table('sm_admins')->insert([
				'authtype' => 'steam',
				'identity' => $steamid,
				'name'     => $order->user->username,
				'flags'    => 'a',
				'immunity' => 50,
			]);
			event(new OrderSynchronized($order));
		}

		// Delete expires orders
		foreach ($expiredOrders as $id) {
			// TODO: remove with whereIn?
			DB::connection('sm_admins')->table('sm_admins')->where('identity', $this->toSteamId2($id->identity))->delete();
			$steam64 = $this->toSteamId64($id->identity);
			$user = User::whereSteamid($steam64)->first();
			if ($user)
				event(new OrderExpired($user));
		}
	}

	public function toSteamId2($steamid)
	{
		$id = new \SteamID($steamid);

		return $id->RenderSteam2();
	}

	public function toSteamId64($steamid)
	{
		$id = new \SteamID($steamid);

		return $id->ConvertToUInt64();
	}
}
