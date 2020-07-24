<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 8/25/2019
 * Time: 9:46 AM
 */

namespace App\Services;

use App\Events\ManualServerSynchronization;
use App\Order;

class OrderDurationCorrection
{
    public function handle(Order $order, int $newDuration)
    {
        $oldDuration = $order->duration;
        $difference = $newDuration - $oldDuration;

        $order->duration = $newDuration;

        if ($order->starts_at && $order->ends_at) {
            $order->ends_at = $order->ends_at->clone()->addDays($difference);
        }
    }
}
