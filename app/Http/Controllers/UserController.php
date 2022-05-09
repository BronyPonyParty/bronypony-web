<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as AuthFacades;

class UserController extends Controller
{
    public function getUserData() {
        return AuthFacades::user();
    }

    public function saveUserData(Request $request) {
        $user = AuthFacades::user();

        $avatar = $request->file('avatar');
        $firstname = $request->post('firstname');
        $lastname = $request->post('lastname');
        $middlename = $request->post('middlename');
//        return exif_read_data($avatar->getClientOriginalName());
//        return $avatar->getClientOriginalName();

//        if (!empty($avatar)) {
//            exif_imagetype($avatar);
//        }

        return getimagesize($avatar);



    }
}
