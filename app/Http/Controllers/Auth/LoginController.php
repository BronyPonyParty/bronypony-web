<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function login(AuthRequest $request) { // Перед выполнением проходит валидация в AuthRequest
        $login = $request->post('login');
        $password = $request->post('password');

        $user = User::whereLogin($login)->wherePassword(md5($password))->whereStatus(true)->first();

        if (empty($user)) abort(400, 'Неверные данные входа');

        //Если данные оказались верны
        $token = '';
        for ($i = 0; $i < 5; $i++) {
            $token = md5(random_bytes(256));
            $session = Session::whereToken($token)->exists();
            if (empty($session)) break;
        }

        $session = new Session();

        $session->user_id = $user->id;
        $session->token = $token;
        $session->term = time() + 3600 * 24 * 2;
        $session->ip = $request->ip();

        $session->save();

        return $token;
    }

    public function logout(Request $request) {
        $token = $request->post('token');

        $authToken = Session::whereToken($token)->first();
        $authToken->removed = 1;

        $authToken->save();
    }
}
