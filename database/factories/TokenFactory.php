<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Token;
use App\User;
use Faker\Generator as Faker;

$factory->define(Token::class, function (Faker $faker) {
	if ($faker->boolean(70))
		$userId = User::inRandomOrder()->first()->id;
	else
		$userId = null;

	return [
		'id'      => $faker->randomLetter . $faker->randomLetter . $faker->randomLetter . $faker->randomLetter . $faker->randomLetter . $faker->randomLetter . $faker->randomLetter . $faker->randomLetter . $faker->randomLetter . $faker->randomLetter . $faker->randomLetter,
		'duration'   => $faker->numberBetween(0, 90),
		'note'       => $faker->text,
		'user_id'    => $userId,
		'expires_at' => $faker->dateTimeBetween('now', '+4 months'),
	];
});
