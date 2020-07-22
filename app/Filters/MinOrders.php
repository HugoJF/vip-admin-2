<?php

namespace App\Filters;

use Illuminate\Support\Facades\Auth;

class MinOrders extends BaseFilter
{
    protected $arguments = ['count'];

    public function isFiltered(array $options)
    {
        $count = $options['count'];

        return auth()->user()->orders()->where('paid', true)->count() < $count;
    }
}
