<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as AuthFacades;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function getUserData() {
        return AuthFacades::user();
    }

    public function saveUserData(Request $request) {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|max:32',
            'lastname' =>'required|max:32',
            'middlename' => 'max:32'
        ], [
            'firstname.required' => 'Поле с именем не может быть пустым',
            'lastname.required' => 'Поле с фамилией не может быть пустым',
            'max' => 'Максимальная длина полей 32 символа'
        ]);

        if ($validator->fails()) {
            abort(400, $validator->getMessageBag());
        }

        $user = AuthFacades::user();
        $avatar = $request->file('avatar');
        $hashAvatar = '';
        $firstname = $request->post('firstname');
        $lastname = $request->post('lastname');
        $middlename = $request->post('middlename');

        if (!empty($avatar)) $hashAvatar = hash_file('md5', $avatar);

        if ($user->avatar !== $hashAvatar && !empty($avatar)) {
            if ($avatar->getSize() > 1000000) abort(413, 'Большой размер файла');
            if (!in_array(exif_imagetype($avatar), [2, 3])) abort(400, 'Мы поддерживаем только изображения png, jpg и jpeg');
            if (getimagesize($avatar)[0] > 512 || getimagesize($avatar)[1] > 512) abort(400, 'Изображение слишком большое, размер картинки должен быть не больше 512x512');

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
        if ($user->middlename !== $middlename) $user->middlename = $middlename;

        $user->save();

        return $user;
    }

    public function getAllData() {
        $user = AuthFacades::user();

        $rows = [
            'id',
            'firstname',
            'lastname',
            'phone_number',
            'mail',
            'avatar',
            'status'
        ];

        return User::select($rows)->where('organization_id', $user->organization_id)->get();
    }
}
