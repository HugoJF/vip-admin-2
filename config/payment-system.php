<?php

$second = 1000;
$minute = $second * 60;
$hour = $minute * 60;
$day = $hour * 24;

return [
	'url'                => env('PAYMENT_SYSTEM_URL'),
	'rechecking-periods' => [
		30 * $second,
		1 * $minute,
		2 * $minute,
		3 * $minute,
		4 * $minute,
		5 * $minute,
		10 * $minute,
		20 * $minute,
		30 * $minute,
		45 * $minute,
		1 * $hour,
		2 * $hour,
		4 * $hour,
		12 * $hour,
		1 * $day,
		2 * $day,
		3 * $day,
		4 * $day,
		7 * $day,
	],
];