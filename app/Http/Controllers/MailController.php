<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mail;

class MailController extends Controller
{
    public function generateCode(Request $request) {
        $validator = Validator::make($request->all(), [
            'mail' => 'required|max:64'
        ]);

        if ($validator->fails()) return response(['errors' => $validator->failed()], 400);

        $mail = $request->post('mail');
        $reg = '/^(([^<>()\[\].,;:\s@"]+(\.[^<>()\[\].,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';

        if (!preg_match($reg, $mail)) return response(['errors' => ['mail' => ['Incorrect' => []]]], 400);

        $user = User::where('mail', $mail)->first();
        if ($user === null) return response(['errors' => ['mail' => ['NotFound' => []]]], 400);
        if ($user->status === 1) return response(['errors' => ['mail' => ['NotFound' => []]]], 400);

        $randomCode = random_int(1000, 9999);

//        Mail::send('mail', ['code' => $code], function ($message) use ($mail) {
//            $message->to($mail, 'Support')->subject('Восстановление пароля');
//            $message->from('support@bronypony.com', 'Support');
//        });

        $code = new Code();
        $code->user_id = $user->id;
        $code->code = $randomCode;
        $code->term = time() + 600;
        $code->save();

        return 'OK';

    }

    public function successCode(Request $request) {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:4',
            'password' => 'required|max:128'
        ]);

        if ($validator->fails()) return response(['errors' => $validator->failed()], 400);

        $code = $request->post('code');
        $password = $request->post('password');
        // логииииикаа
    }
}
