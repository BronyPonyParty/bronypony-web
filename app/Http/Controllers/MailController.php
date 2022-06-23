<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as AuthFacade;
use Illuminate\Support\Facades\Validator;
use Mail;
use App\Crypt;

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

        Code::where('user_id', $user->id)->update(['removed' => true]);

        $randomCode = random_int(1000, 9999);

       Mail::send('mail', ['code' => $randomCode], function ($message) use ($mail) {
           $message->to($mail, 'Support')->subject('Восстановление пароля');
           $message->from('support@bronypony.com', 'Support');
       });

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

        $userCode = Code::where('code', $code)->where('term', '>', time())->where('removed', false)->first();
        if ($userCode === null) return response(['errors' => ['code' => ['NotFound' => []]]], 400);

        list($hash, $salt) = Crypt::hash($password);

        User::where('id', $userCode->user_id)->update(['password' => $hash, 'salt' => $salt]);
        Code::where('user_id', $userCode->user_id)->update(['removed' => true]);

        return 'OK';
    }

    public function registration(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:64',
            'address' => 'required|max:128',
            'phone' => 'required|digits_between:6,16'
        ]);

        if ($validator->fails()) return response(['errors' => $validator->failed()], 400);

        $name = $request->post('name');
        $address = $request->post('address');
        $phone = $request->post('phone');

        Mail::send('registration', ['name' => $name, 'address' => $address, 'phone' => $phone], function ($message) {
            $message->to('tat.putintsewa@yandex.ru', 'Support')->subject('Регистрация организации');
            $message->from('support@bronypony.com', 'Support');
        });

        return 'OK';
    }

    public function feedback(Request $request) {
        $validator = Validator::make($request->all(), [
            'mail' => 'required|max:64',
            'description' => 'required|max:512',
        ]);

        if ($validator->fails()) return response(['errors' => $validator->failed()], 400);

        $user = AuthFacade::user();
        $mail = $request->post('mail');
        $description = preg_replace("/\s+/u", " ", str_replace(array("\r\n", "\r", "\n"), '', $request->post('description')));
        $reg = '/^(([^<>()\[\].,;:\s@"]+(\.[^<>()\[\].,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';

        if (!preg_match($reg, $mail)) return response(['errors' => ['mail' => ['Incorrect' => []]]], 400);

        Mail::send('feedback', ['user' => $user->firstname, 'mail' => $mail, 'description' => $description], function ($message) {
            $message->to('tat.putintsewa@yandex.ru', 'Support')->subject('Помощь');
            $message->from('support@bronypony.com', 'Support');
        });

        return 'OK';
    }
}
