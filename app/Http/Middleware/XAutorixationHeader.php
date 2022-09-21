<?php

namespace App\Http\Middleware;

use Closure;

class XAutorixationHeader
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
        if($auth = $request->header('X-Authorization')) {
            $request->headers->set('Authorization', $auth);
        }

        return $next($request);
    }
}
