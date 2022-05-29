<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TechnicController;
use App\Http\Controllers\StatementController;
use App\Http\Middleware\Auth;

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
    Route::post('logout', [LoginController::class, 'logout']);

    Route::post('user/getUserData', [UserController::class, 'getUserData']);
    Route::post('user/saveUserData', [UserController::class, 'saveUserData']);

    Route::post('technic/getList', [TechnicController::class, 'getTechnicList']);
    Route::post('technic/getInfo', [TechnicController::class, 'getTechnicInfo']);

    Route::any('statement/get', [StatementController::class, 'get']);
    Route::post('statement/accept', [StatementController::class, 'accept']);
    Route::post('statement/complete', [StatementController::class, 'complete']);
});

Route::get('test', function () {
    DB::enableQueryLog();

//    $repairs = Repair::whereHas('user', $filter = function ($query) {
//        $query->where('organization_id', 1);
//    })->with(['user' => $filter])->get();

//    foreach ($users as $user) {
//        echo $user . '<br>';
//    }


//    dd($mass);
    dd(DB::getQueryLog());
});
