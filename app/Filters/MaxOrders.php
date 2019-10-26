<?php

namespace App\Filters;

use Illuminate\Support\Facades\Auth;

class MaxOrders extends BaseFilter
{
	protected $arguments = ['count'];

	public function isFiltered(array $options)
	{
		$count = $options['count'];

		return Auth::user()->orders()->where('paid', true)->count() > $count;
	}
}