<?php

namespace Tests\Unit;

use App\Admin;
use App\Classes\VipSynchronizer;
use App\Services\AdminService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class VipSynchronizerTest extends TestCase
{
    public function test_needs_update_list()
    {
        $current = [
            steamid2('STEAM_0:0:1') => '1',
            steamid2('STEAM_0:0:2') => '1',
            steamid2('STEAM_0:0:3') => '1',
        ];
        $expected = [
            steamid2('STEAM_0:0:1') => '2',
            steamid2('STEAM_0:0:2') => '1',
            steamid2('STEAM_0:0:4') => '1',
        ];

        $sync = new VipSynchronizer($current, $expected);

        $update = $sync->getNeedsUpdateList();
        $remove = $sync->getNeedsRemovalList();
        $add = $sync->getNeedsAditionList();

        $this->assertEquals([
            steamid2('STEAM_0:0:1') => '2',
        ], $update);

        $this->assertEquals([
            steamid2('STEAM_0:0:3') => '1',
        ], $remove);

        $this->assertEquals([
            steamid2('STEAM_0:0:4') => '1',
        ], $add);
    }
}
