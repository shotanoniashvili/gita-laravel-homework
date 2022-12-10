<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetSanctumTokenInCookies
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()) {
            return $next($request);
        }

        $token = $request->cookie('auth_token');

        if (!$token) {
            return $next($request)->withCookie(cookie(
                name: 'auth_token',
                value: $request->user()->createToken(md5(rand()))->plainTextToken,
                minutes: config('sanctum.expiration'),
                path: '/'
            ));
        }

        return $next($request);
    }
}
