<?php

namespace App\Http\Middleware;

use App\Exceptions\NotAffiliateException;
use Closure;

class Affiliate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     * @throws NotAffiliateException
     */
    public function handle($request, Closure $next)
    {
        // TODO: split in 2 exceptions: NotLoggedIn?
        if (!auth()->check() || !auth()->user()->affiliate) {
            throw new NotAffiliateException();
        }

        return $next($request);
    }
}
