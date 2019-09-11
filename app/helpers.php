<?php

if (!function_exists('random_id')) {

	function random_id($length)
	{
		return substr(md5(microtime(true)), 0, $length);
	}
}