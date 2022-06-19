<?php

namespace App\Http\Controllers\Auth;

use App\Crypt;
use App\Http\Controllers\Controller;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function login(Request $request) { // Перед выполнением проходит валидация в AuthRequest
        $validator = Validator::make($request->all(), [
            'login' => 'required|max:32',
            'password' => 'required|max:128',
        ]);

        if ($validator->fails()) return response(['errors' => $validator->failed()], 400);

        $login = $request->post('login');
        $password = $request->post('password');

        $user = User::whereLogin($login)->where('status', '!=', 1)->first();
        if (empty($user)) return response(['errors' => ['password' => ['Incorrect' => []], 'login' => ['Incorrect' => []]]], 400);

        if ( !Crypt::verify($password, $user->salt, $user->password) ) return response(['errors' => ['password' => ['Incorrect' => []], 'login' => ['Incorrect' => []]]], 400);


        // Если данные оказались верны
        // Генерация токена для сессии
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

        return [$token, $user];
    }

    public function logout(Request $request) {
        $token = $request->route('token');

        $authToken = Session::whereToken($token)->first();
        $authToken->removed = 1;

        $authToken->save();
    }
}
