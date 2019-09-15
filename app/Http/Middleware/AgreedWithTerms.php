<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AgreedWithTerms
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$enforcing = config('vip-admin.enforce-terms', false);

		if (!$enforcing || Auth::check() && Auth::user()->terms === true) {
			return $next($request);
		} else {
			flash()->error('Você ainda não revisou e concordou com os termos!');

			return redirect('/settings');
		}
	}
}
