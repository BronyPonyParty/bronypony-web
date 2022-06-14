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
        if (empty($token)) abort(401, 'Не авторизован');

        $session = Session::whereToken($token)->whereRemoved(false)->first();
        if (empty($session)) abort(401, 'Не авторизован');

        if ($session->term < time()) {
            $session->removed = true;
            $session->save();
            abort(401, 'Не авторизован');
        }

        $user = User::whereId($session->user_id)->where('status', '!=', 1)->first();
        if (empty($user)) abort(401, 'Не авторизован');

        AuthFacades::login($user);
        return $next($request);
    }
}
