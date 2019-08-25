<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	protected $casts = [
		'created_at' => 'datetime:c',
		'updated_at' => 'datetime:c',
	];
}
