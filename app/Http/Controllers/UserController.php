<?php

namespace App\Http\Controllers;

use App\Crypt;
use App\Models\Repair;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as AuthFacade;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function getUserData()
    {
        return AuthFacade::user();
    }

    public function saveUserData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|max:32',
            'lastname' => 'required|max:32'
        ]);

        if ($validator->fails()) return response(['errors' => $validator->failed()], 400);

        $user = AuthFacade::user();
        $avatar = $request->file('avatar');
        $hashAvatar = '';
        $firstname = $request->post('firstname');
        $lastname = $request->post('lastname');

        if (!empty($avatar)) $hashAvatar = hash_file('md5', $avatar);

        if ($user->avatar !== $hashAvatar && !empty($avatar)) {
            if ($avatar->getSize() > 1000000) return response(['errors' => ['avatar' => ['BigSize' => []]]], 413);
            if (!in_array(exif_imagetype($avatar), [2, 3])) return response(['errors' => ['avatar' => ['NotSupported' => []]]], 400);
            if (getimagesize($avatar)[0] > 512 || getimagesize($avatar)[1] > 512) return response(['errors' => ['avatar' => ['HighResolution' => []]]], 400);

            // Проверка наличия путя и удаляем лишние файлы, иначе создаём путь к картинке
            $path = 'storage\\uploads\\avatars\\' . $user->id;
            if (file_exists($path)) {
                foreach (glob($path . '\\*') as $file) {
                    unlink($file);
                }
            } else {
                mkdir($path);
            }

            Image::make($avatar)->resize(512, 512)->save($path . '\\' . $hashAvatar . '.png'); // меняем размер файла и сохраняем
            $user->avatar = $hashAvatar;
        }

        if ($user->firstname !== $firstname) $user->firstname = $firstname;
        if ($user->lastname !== $lastname) $user->lastname = $lastname;

        $user->save();

        return 'OK';
    }

    // access level 8
    public function getAllData()
    {
        $user = AuthFacade::user();

        $rows = [
            'id',
            'firstname',
            'lastname',
            'phone_number',
            'mail',
            'avatar',
            'status'
        ];

        return User::select($rows)->where('organization_id', $user->organization_id)->where('status', '>=', 2)->get();
    }

    public function getInterval(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'startDate' => 'required|integer',
            'endDate' => 'required|integer',
            'userId' => 'required|integer',
        ]);

        if ($validator->fails()) return response(['errors' => $validator->failed()], 400);

        $startDate = $request->post('startDate');
        $endDate = $request->post('endDate');
        $userid = $request->post('userId');
        $authUser = AuthFacade::user();

        // Возвращаем количество выполненных заявления за указанный интервал,
        // также проверяем, id организации, чтобы случайно не достать пользователя из другой организации
        return Repair::where('repairman_id', $userid)
            ->whereHas('report', function ($query) use ($startDate, $endDate, $authUser) {
                $query->whereHas('user', function ($query) use ($authUser) {
                    $query->select('id')->where('organization_id', $authUser->organization_id);
                })->select('id')->where('status', 4)->whereBetween('complete_date', [$startDate, $endDate]);
            })->count('id');
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userId' => 'required|integer'
        ]);

        if ($validator->fails()) return response(['errors' => $validator->failed()], 400);

        $deleteUserId = $request->post('userId');
        $authUser = AuthFacade::user();

        $user = User::where('id', $deleteUserId)->where('organization_id', $authUser->organization_id)
            ->whereIn('status', [2, 4])->update(['status' => 1]);

        Session::where('user_id', $deleteUserId)->where('term', '>', time())->where('removed', false)
            ->update(['removed' => true]);

        if ($user === 0) abort(400, json_encode('Данного пользователя не существует, либо он уже удалён'));

        return 'OK';
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required:max:32',
            'lastname' => 'required|max:32',
            'login' => 'required|max:64',
            'password' => 'required|max:128',
            'post' => 'required|integer|min:2|max:4'
        ]);

        if ($validator->fails()) return response(['errors' => $validator->failed()], 400);

        $authUser = AuthFacade::user();
        $firstname = $request->post('firstname');
        $lastname = $request->post('lastname');
        $login = $request->post('login');
        $password = $request->post('password');
        $status = $request->post('post');
        $validPosts = [2, 4];

        if (!in_array($status, $validPosts)) return response(['errors' => ['post' => ['NotFound' => []]]], 400);

        $unique = User::where('login', $login)->first();
        if (!empty($unique)) return response(['errors' => ['login' => ['Busy' => []]]], 400);

        list($hash, $salt) = Crypt::hash($password);

        $user = new User();
        $user->firstname = $firstname;
        $user->lastname = $lastname;
        $user->login = $login;
        $user->password = $hash;
        $user->salt = $salt;
        $user->organization_id = $authUser->organization_id;
        $user->status = $status;
        $user->save();

        return $user->id;
    }

    public function changeMail(Request $request) {
        $validator = Validator::make($request->all(), [
            'mail' => 'required|max:64',
            'password' => 'required|max:128'
        ]);

        if ($validator->fails()) return response(['errors' => $validator->failed()], 400);

        $mail = $request->post('mail');
        $password = $request->post('password');
        $authUser = AuthFacade::user();
        $reg = '/^(([^<>()\[\].,;:\s@"]+(\.[^<>()\[\].,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';

        if (!preg_match($reg, $mail)) return response(['errors' => ['mail' => ['Incorrect' => []]]], 400);
        if ($authUser->mail === $mail) return response(['errors' => ['mail' => ['Using' => []]]], 400);
        if ( !Crypt::verify($password, $authUser->salt, $authUser->password) ) return response(['errors' => ['password' => ['Incorrect' => []]]], 400);

        $count = User::where('mail', $mail)->where('id', '!=', $authUser->id)->count();
        if ($count !== 0) return response(['errors' => ['mail' => ['Busy' => []]]], 400);

        User::where('id', $authUser->id)->update(['mail' => $mail]);

        return 'OK';
    }

    public function changePassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'newPassword' => 'required|max:128',
            'oldPassword' => 'required|max:128',
            'verPassword' => 'required|max:128'
        ]);

        if ($validator->fails()) return response(['errors' => $validator->failed()], 400);

        $newPassword = $request->post('newPassword');
        $oldPassword = $request->post('oldPassword');
        $verPassword = $request->post('verPassword');
        $authUser = AuthFacade::user();

        if ($newPassword !== $verPassword) return response(['errors' => ['newPassword' => ['NotMatch' => []], 'verPassword' => ['NotMatch' => []]]], 400);
        if ( !Crypt::verify($oldPassword, $authUser->salt, $authUser->password) ) return response(['errors' => ['oldPassword' => ['Incorrect' => []]]], 400);
        if ($oldPassword === $newPassword) return response(['errors' => ['oldPassword' => ['Match' => []], 'newPassword' => ['Match' => []]]], 400);

        list($hash, $salt) = Crypt::hash($newPassword);

        User::where('id', $authUser->id)->update(['password' => $hash, 'salt' => $salt]);

        return 'OK';
    }

    public function changePhone(Request $request) {
        $validator = Validator::make($request->all(), [
            'password' => 'required|max:128',
            'phone' => 'required|digits_between:6,16'
        ]);

        if ($validator->fails()) return response(['errors' => $validator->failed()], 400);

        $phone = $request->post('phone');
        $password = $request->post('password');
        $authUser = AuthFacade::user();

        if ($phone === $authUser->phone_number) return response(['errors' => ['phone' => ['Using' => []]]], 400);
        if ( !Crypt::verify($password, $authUser->salt, $authUser->password) ) return response(['errors' => ['password' => ['Incorrect' => []]]], 400);

        // Проверка на занятость данного номера
        $phoneUsed = User::where('phone_number', $phone)->first();
        if (!empty($phoneUsed)) return response(['errors' => ['phone' => ['Busy' => []]]], 400);

        User::where('id', $authUser->id)->update(['phone_number' => $phone]);

        return 'OK';
    }

    public function getSessions() {
        $authUser = AuthFacade::user();

        $rows = ['id', 'user_id', 'token', 'term', 'ip'];

        return Session::select($rows)->where('user_id', $authUser->id)->where('term', '>', time())->where('removed', 0)->get();
    }

    public function dropSession(Request $request) {
        $validator = Validator::make($request->all(), [
            'sessionId' => 'required|integer',
            'password' => 'required|max:128'
        ]);

        if ($validator->fails()) return response(['errors' => $validator->failed()], 400);

        $authUser = AuthFacade::user();
        $sessionId = $request->post('sessionId');
        $password = $request->post('password');

        if ( !Crypt::verify($password, $authUser->salt, $authUser->password) ) return response(['errors' => ['password' => ['Incorrect' => []]]], 400);

        $data = Session::where('user_id', $authUser->id)->where('id', $sessionId)->where('removed', 0)
            ->update(['removed' => 1]);

        if ($data === 0) return response(['errors' => ['session' => ['NotFound' => []]]], 400);

        return 'OK';
    }
}
