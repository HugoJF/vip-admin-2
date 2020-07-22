<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->admin) {
            $url = $request->url();
            flash()->error("Você não possui permissões para acessar <strong>$url</strong>!");

            return redirect()->route('home');
        }

        return $next($request);
    }
}
