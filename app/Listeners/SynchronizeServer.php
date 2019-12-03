<?php

namespace App\Listeners;

use App\Admin;
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
	 * Handle the event.
	 *
	 * @param object $event
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

			$flags = config('vip-admin.vip-flag', 'a');
			if ($order->user->hidden_flags)
				$flags .= config('vip-admin.hidden-flags-flag', 'o');

			return [steamid2($id) => [
				'username' => $order->user->username,
				'flags'    => $flags,
			]];
		});
	}

	private function mapAdminsToInfo($admins)
	{
		$ids = $admins->map(function (Admin $admin) {
			return steamid64($admin->steamid);
		});
		$users = User::query()->whereIn('steamid', $ids)->get();

		return $admins->mapWithKeys(function (Admin $admin) use ($users) {
			$user = $users[ $admin->steamid ];
			$flags = $admin->flags;
			if ($user && $user->hidden_flags)
				$flags = merge_sm_flags($flags, config('vip-admin.hidden-flags-flag', 'o'));

			return [steamid2($admin->steamid) => [
				'username' => $admin->username,
				'flags'    => $flags,
			]];
		});
	}

	private function fetchCurrentDatabase()
	{
		$existing = DB::connection('sm_admins')->table('sm_admins')->select(['identity', 'flags'])->get()->unique('identity');

		return $existing->mapWithKeys(function ($r) {
			return [$r->identity => $r->flags];
		});
	}

	private function updateDatabase($currentOrders, $admins)
	{
		$vips = $this->mapOrdersToInfo($currentOrders)->toArray();
		$adms = $this->mapAdminsToInfo($admins)->toArray();

		$inter = array_intersect_key($vips, $adms);
		$result = array_merge($vips, $adms);

		foreach ($inter as $id => $flag) {
			$result[ $id ] = merge_sm_flags($vips[ $id ], $adms[ $id ]);
		}

		$current = $this->fetchCurrentDatabase()->toArray();

		$pending = array_diff_key($result, $current);
		$update = array_intersect_ukey($result, $current, function ($a, $b) {
			return strcmp($a, $b);
		});
		$expired = array_diff_key($current, $result);

		$this->updateAdmins($update);
		$this->removeAdmins($expired);
		$this->addAdmins($pending);
	}

	private function updateAdmins($data)
	{
		foreach ($data as $id => $d) {
			$this->updateAdmin($id, $d['username'], $d['flags']);
		}
	}

	private function updateAdmin($steamid, $username, $flag): void
	{
		DB::connection('sm_admins')->table('sm_admins')->where('identity', $steamid)->update([
			'flags' => $flag,
		]);
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
