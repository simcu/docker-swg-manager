<?php

namespace App\Http\Middleware;

use Closure;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!session('logined.user')->roles()->where('id', 1)->first()) {
            return redirect('/');
        }
        return $next($request);
    }
}
