<?php

namespace App;

use App\Filters\MaxOrders;
use App\Filters\MinOrders;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	use Filterable;

	protected $fillable = ['title', 'duration', 'cost', 'original_cost', 'description', 'filter'];

	protected $filters = [
		'HasAtLeast' => MinOrders::class,
		'MaxOrders' => MaxOrders::class,
	];
}
