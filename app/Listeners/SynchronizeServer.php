<?php

namespace App\Listeners;

use App\Admin;
use App\Classes\VipSynchronizer;
use App\Order;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SynchronizeServer implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var string
     */
    private $vipFlag;

    /**
     * @var string
     */
    private $hiddenFlagsFlag;

    private $current;

    private $expected;

    public function __construct()
    {
        $this->vipFlag = config('vip-admin.vip-flag', 'a');
        $this->hiddenFlagsFlag = config('vip-admin.hidden-flags-flag', 'o');
    }

    public function handle($event): void
    {
        $this->loadCurrent();
        $this->loadExpected();

        $current = $this->mapIdToFlags($this->current)->toArray();
        $expected = $this->mapIdToFlags($this->expected)->toArray();

        $diff = new VipSynchronizer($current, $expected);

        foreach ($diff->getNeedsUpdateList() as $id => $flags) {
            $data = $this->expected[ $id ];
            $this->updateAdmin($id, $data['username'], $flags);
        }

        foreach ($diff->getNeedsAditionList() as $id => $flags) {
            $data = $this->expected[ $id ];
            $this->addAdmin($id, $data['username'], $flags);
        }

        $this->removeAdmins(array_keys($diff->getNeedsRemovalList()));
    }

    protected function loadCurrent()
    {
        $existing = DB::connection('sm_admins')
                      ->table('sm_admins')
                      ->select(['identity', 'name', 'flags'])
                      ->get()
                      ->unique('identity');

        $this->current = $existing->mapWithKeys(function ($r) {
            return [$r->identity => [
                'username' => $r->name,
                'flags'    => $r->flags,
            ]];
        });
    }

    protected function loadExpected(): void
    {
        $vips = $this->loadExpectedVips()->toArray();
        $admins = $this->loadExpectedAdmins()->toArray();

        // Get VIPs that are also admins
        $intersect = array_intersect_key($vips, $admins);
        $result = array_merge($vips, $admins);

        // Merge VIP and admin flags
        foreach ($intersect as $id => $flag) {
            $result[ $id ]['flags'] = merge_sm_flags($vips[ $id ]['flags'], $admins[ $id ]['flags']);
        }

        $this->expected = collect($result);
    }

    protected function loadExpectedVips(): Collection
    {
        $orders = Order::query()
                       ->paid()
                       ->valid()
                       ->started()
                       ->notExpired()
                       ->get();

        // Map with SteamID as key to remove duplicates
        // TODO: merge duplicates (map, groupBy, map)
        return $orders->mapWithKeys(function ($order) {
            // If Order is not transferred, use owner SteamID
            $id = $order->steamid ?? $order->user->steamid;

            // Build user flags
            $hidden = $order->user->hidden_flags;
            $flags = merge_sm_flags($this->vipFlag, $hidden ? $this->hiddenFlagsFlag : '');

            return [steamid2($id) => [
                'username' => $order->user->username,
                'flags'    => $flags,
            ]];
        });
    }

    protected function loadExpectedAdmins(): Collection
    {
        $admins = Admin::all();

        // Get list of admin IDs
        $ids = $admins->map(function (Admin $admin) {
            return steamid64($admin->steamid);
        });

        // Check admins that are also a User
        /** @var Collection $users */
        $users = User::query()->whereIn('steamid', $ids)->get();

        // TODO: also merge duplicates
        return $admins->mapWithKeys(function (Admin $admin) use ($users) {
            $user = $users->firstWhere('steamid', steamid64($admin->steamid));

            $hidden = $user->hidden_flags ?? false;
            $flags = merge_sm_flags($admin->flags, $hidden ? $this->hiddenFlagsFlag : '');

            return [steamid2($admin->steamid) => [
                'username' => $admin->username,
                'flags'    => $flags,
            ]];
        });
    }

    protected function mapIdToFlags(Collection $collection): Collection
    {
        return $collection->map(function ($item) {
            return $item['flags'];
        });
    }

    private function updateAdmin($steamid, $username, $flag): void
    {
        DB::connection('sm_admins')->table('sm_admins')->where('identity', $steamid)->update([
            'flags' => $flag,
        ]);
    }

    private function addAdmin($steamid, $username, $flag): void
    {
        // Strip non alpha-numeric chars from username
        $cleanedUsername = preg_replace('/[^A-Za-z0-9_-]/', '_', $username);

        DB::connection('sm_admins')->table('sm_admins')->insert([
            'authtype' => 'steam',
            'identity' => $steamid,
            'name'     => $cleanedUsername,
            'flags'    => $flag,
            'immunity' => 50,
        ]);
    }

    private function removeAdmins($ids): void
    {
        DB::connection('sm_admins')->table('sm_admins')->whereIn('identity', $ids)->delete();
    }
}
