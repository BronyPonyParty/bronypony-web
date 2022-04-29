<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as AuthFacades;

class UserController extends Controller
{
    public function getUserData() {
        return AuthFacades::user();
    }
}
