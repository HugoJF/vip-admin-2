<?php

if (!function_exists('random_id')) {
	function random_id($length)
	{
		return substr(md5(microtime(true)), 0, $length);
	}
}

if (!function_exists('steamid')) {
	function steamid($steamid)
	{
		return new \SteamID($steamid);
	}
}

if (!function_exists('steamid2')) {
	function steamid2($id)
	{
		return steamid($id)->RenderSteam2();
	}
}

if (!function_exists('steamid64')) {
	function steamid64($id)
	{
		return steamid($id)->ConvertToUInt64();
	}
}

if (!function_exists('steamid3')) {
	function steamid3($id)
	{
		return steamid($id)->RenderSteam3();
	}
}