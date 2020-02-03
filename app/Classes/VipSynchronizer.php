<?php

namespace App\Classes;

class VipSynchronizer
{
    /**
     * VIPs that are currently stored in the database
     *
     * @var array
     */
    private $current;

    /**
     * VIPs that are valid and active
     *
     * @var array
     */
    private $expected;

    /**
     * List of VIPs that need flag updates
     *
     * @var array
     */
    private $needsUpdate;

    /**
     * @var array
     */
    private $needsRemoval;

    /**
     * @var array
     */
    private $needsAddition;

    public function __construct(array $current, array $expected)
    {
        $this->current = $this->normalizeSteamidList($current);
        $this->expected = $this->normalizeSteamidList($expected);

        $this->handle();
    }

    protected function normalizeSteamidList(array $ids)
    {
        return collect($ids)->mapWithKeys(function ($flags, $id) {
            return [steamid2($id) => $flags];
        })->toArray();
    }

    protected function handle()
    {
        // Compute intersections only using keys (each variable holds one side of the intersection)
        $intersectCurrent = array_intersect_key($this->current, $this->expected);
        $intersectExpected = array_intersect_key($this->expected, $this->current);

        // Compute the difference between intersections to return SteamIDs that were modified
        // Result is the expected value
        $this->needsUpdate = array_diff_assoc($intersectExpected, $intersectCurrent);

        // Compute differences between lists with different bases to separate IDs that need to be added and removed
        $this->needsRemoval = array_diff_key($this->current, $this->expected);
        $this->needsAddition = array_diff_key($this->expected, $this->current);
    }

    public function getNeedsUpdateList()
    {
        return $this->needsUpdate;
    }

    public function getNeedsRemovalList()
    {
        return $this->needsRemoval;
    }

    public function getNeedsAditionList()
    {
        return $this->needsAddition;
    }
}
