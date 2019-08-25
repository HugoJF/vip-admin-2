<?php

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
	$randomId = $faker->numberBetween(3650912, 96509127);
	$steamId = \App\Classes\SteamID::normalizeSteamID("STEAM_0:1:{$randomId}");

	return [
		'name'              => $faker->name,
		'username'          => $faker->name,
		'steamid'           => $steamId,
		'avatar'            => 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/45/45be9bd313395f74762c1a5118aee58eb99b4688_full.jpg',
		'email'             => $faker->unique()->safeEmail,
	];
});
