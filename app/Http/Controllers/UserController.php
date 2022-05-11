<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as AuthFacades;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function getUserData() {
        return AuthFacades::user();
    }

    public function saveUserData(Request $request) {
        $user = AuthFacades::user();
        $avatar = $request->file('avatar');
        $hashAvatar = '';
        $firstname = $request->post('firstname');
        $lastname = $request->post('lastname');
        $middlename = $request->post('middlename');

        if (empty($firstname) || strlen($firstname) > 32) abort(400, 'Пустая или длинная строка');
        if (empty($lastname) || strlen($lastname) > 32) abort(400, 'Пустая или длинная строка');
        if (strlen($middlename) > 32) abort(400, 'Длинная строка');

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
}
