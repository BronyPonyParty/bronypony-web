<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AccessLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $level)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user->status < $level) abort(403, json_encode('Недостаточно прав для совершения данного действия'));
        return $next($request);
    }
}
