<?php

use App\Models\MovingTechnic;
use App\Models\Premise;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EquipmentController;
use App\Http\Middleware\Auth;

use App\Models\Technic;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [LoginController::class, 'login']);


Route::prefix('{token}')->middleware(Auth::class)->group(function () {
    Route::post('getUserData', [UserController::class, 'getUserData']);
    Route::post('logout', [LoginController::class, 'logout']);
    Route::post('saveUserData', [UserController::class, 'saveUserData']);
    Route::post('getTechnicList', [EquipmentController::class, 'getTechnicList']);
    Route::post('getTechnicInfo', [EquipmentController::class, 'getTechnicInfo']);
});

Route::get('test', function () {
    \Illuminate\Support\Facades\DB::enableQueryLog();

    $usersIds = [];
    $rows = \App\Models\MovingTechnic::where('technic_id', 2)->get();
    foreach ($rows as $row) $usersIds[] = $row->user_id;

    $users_rows = \App\Models\User::select(['id', 'lastname'])->whereIn('id', $usersIds)->get();

    $usernames = [];
    foreach ($users_rows as $row) $usernames[$row->id] = $row->lastname;

    foreach ($rows as $row) {
        echo $usernames[$row->user_id] . '<br>';
    }

    dd(\Illuminate\Support\Facades\DB::getQueryLog());
});
