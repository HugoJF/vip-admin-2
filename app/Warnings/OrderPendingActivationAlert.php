<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 8/28/2019
 * Time: 7:28 PM
 */

namespace App\Warnings;

use HugoJF\ModelWarnings\Contracts\Warning;

class OrderPendingActivationAlert extends Warning
{
    private $pendingOrders;

    public function triggered()
    {
        $this->pendingOrders = $this->context->orders()->wherePaid(true)->whereNull('starts_at')->count();

        return $this->pendingOrders > 0;
    }

    /**
     * @inheritDoc
     */
    public function buildMessage()
    {
        $s = $this->pendingOrders === 1 ? '' : 's';

        return [
            'message' => "Você tem $this->pendingOrders pedido$s pendente$s!",
            'level'   => 'danger',
            'url'     => route('orders.index'),
        ];
    }
}
