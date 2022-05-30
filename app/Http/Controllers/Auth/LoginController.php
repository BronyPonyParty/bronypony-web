<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function login(Request $request) { // Перед выполнением проходит валидация в AuthRequest
        $validator = Validator::make($request->all(), [
            'login' => 'required|max:32',
            'password' => 'required|max:128',
        ], [
            'required' => 'Все поля должны быть заполнены',
            'login.max' => 'Максимальная длина логина 32 символа',
            'password.max' => 'Максимальная длина пароля 128 символов'
        ]);

        if ($validator->fails()) {
            abort(400, $validator->getMessageBag());
        }

        $login = $request->post('login');
        $password = $request->post('password');

        $user = User::whereLogin($login)->wherePassword(md5($password))->where('status', '!=', 1)->first();

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

        return [$token, $user];
    }

    public function logout(Request $request) {
        $token = $request->route('token');

        $authToken = Session::whereToken($token)->first();
        $authToken->removed = 1;

        $authToken->save();
    }
}
