<?php

namespace App\Listeners;

use App\Admin;
use App\Events\OrderExpired;
use App\Events\OrderSynchronized;
use App\Order;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class SynchronizeServer implements ShouldQueue
{
	use InteractsWithQueue;

	/**
	 * Handle the event.
	 *
	 * @param  object $event
	 *
	 * @return void
	 */
	public function handle($event)
	{
		$expiredOrders = Order::expired()->synced()->get();
		$this->expireOrders($expiredOrders);

		$pendingOrders = Order::pending()->get();
		$this->syncOrders($pendingOrders);

		$currentOrders = Order::active()->get();
		$admins = Admin::all();

		$this->updateDatabase($currentOrders, $admins);
	}

	private function expireOrders($expiredOrders)
	{
		foreach ($expiredOrders as $order) {
			$this->expireOrder($order);
		}
	}

	private function expireOrder(Order $order)
	{
		$order->synced_at = null;
		$order->save();

		event(new OrderExpired($order));
	}

	private function syncOrders($pendingOrders)
	{
		// Insert order into database
		foreach ($pendingOrders as $order) {
			$this->syncOrder($order);
		}
	}

	public function syncOrder(Order $order)
	{
		$order->synced_at = Carbon::now();
		$order->save();

		event(new OrderSynchronized($order));
	}

	private function mapOrdersToInfo($orders)
	{
		// Map SteamID => Username to remove duplicates
		return $orders->mapWithKeys(function ($order) {
			$id = $order->steamid ?? $order->user->steamid;

			return [steamid2($id) => [
				'username' => $order->user->username,
				'flags'     => config('vip-admin.vip-flag', 'a'),
			]];
		});
	}

	private function mapAdminsToInfo($admins)
	{
		return $admins->mapWithKeys(function (Admin $admin) {
			return [steamid2($admin->steamid) => [
				'username' => $admin->username,
				'flags'     => $admin->flags,
			]];
		});
	}

	private function fetchCurrentDatabase()
	{
		$existing = DB::connection('sm_admins')->table('sm_admins')->select('identity')->get()->unique('identity');

		return $existing->mapWithKeys(function ($r) {
			return [$r->identity => $r->identity];
		});
	}

	private function updateDatabase($currentOrders, $admins)
	{
		$vips = $this->mapOrdersToInfo($currentOrders);
		$adms = $this->mapAdminsToInfo($admins);

		$result = array_merge($vips->toArray(), $adms->toArray());

		$current = $this->fetchCurrentDatabase()->toArray();

		$pending = array_diff_key($result, $current);
		$expired = array_diff_key($current, $result);

		$this->addAdmins($pending);
		$this->removeAdmins($expired);
	}

	private function addAdmins($data)
	{
		foreach ($data as $id => $d) {
			$this->addAdmin($id, $d['username'], $d['flags']);
		}
	}

	private function addAdmin($steamid, $username, $flag): void
	{
		DB::connection('sm_admins')->table('sm_admins')->insert([
			'authtype' => 'steam',
			'identity' => $steamid,
			'name'     => $username,
			'flags'    => $flag,
			'immunity' => 50,
		]);
	}

	private function removeAdmins($ids): void
	{
		DB::connection('sm_admins')->table('sm_admins')->whereIn('identity', $ids)->delete();
	}
}
