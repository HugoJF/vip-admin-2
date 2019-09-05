<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Order;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Order::class, function (Faker $faker) {
	$duration = $faker->numberBetween(0, 90);

	$start = Carbon::now()->subDays(15)->addDays($faker->numberBetween(0, 30));
	$end = $start->clone()->addDays($duration);

	$paid = $faker->boolean(80);
	$canceled = $faker->boolean(80);

	$userId = User::inRandomOrder()->first();

	return [
		'id' => $faker->randomLetter . $faker->randomLetter . $faker->randomLetter . $faker->randomLetter . $faker->randomLetter . $faker->randomLetter . $faker->randomLetter . $faker->randomLetter . $faker->randomLetter . $faker->randomLetter,
		'duration'  => $duration,
		'starts_at' => $start,
		'ends_at'   => $end,
		'paid'      => $paid,
		'canceled'  => $canceled,
		'user_id'   => $userId,
	];
});
