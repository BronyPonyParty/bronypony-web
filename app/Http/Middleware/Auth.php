<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Session;
use Illuminate\Support\Facades\Auth as AuthFacades;

class Auth
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
        $token = $request->route('token');
        if (empty($token)) abort(401, 'Доступ закрыт');

        $session = Session::whereToken($token);

        if ($session == null) return response('ошибка');

        if ($session->removed == true) return response('ошибка');

        if ($session->term < time()) abort(401, 'Доступ закрыт');

        $user = User::whereId($session->user_id)->first();
        AuthFacades::login($user);
        return $next($request);
    }
}
