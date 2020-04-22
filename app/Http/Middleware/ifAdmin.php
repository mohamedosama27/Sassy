<?php

namespace App\Http\Middleware;

use Closure;

class ifAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->user()->type!=1)
        {
            abort(404);
        }
        return $next($request);
    }
}
