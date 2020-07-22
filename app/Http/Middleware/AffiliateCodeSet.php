<?php

namespace App\Http\Middleware;

use App\Exceptions\AffiliateCodeNotSetException;
use Closure;

class AffiliateCodeSet
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     * @throws AffiliateCodeNotSetException
     */
    public function handle($request, Closure $next)
    {
        // TODO split into 3: logged, affiliate and code
        if (!auth()->check() || !auth()->user()->affiliate_code) {
            throw new AffiliateCodeNotSetException();
        }

        return $next($request);
    }
}
