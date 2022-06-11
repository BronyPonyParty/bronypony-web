<?php

use App\Models\MovingTechnic;
use App\Models\Premise;
use App\Models\Repair;
use App\Models\Report;
use App\Models\Technic;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TechnicController;
use App\Http\Controllers\StatementController;
use App\Http\Middleware\Auth;
use App\Http\Middleware\AccessLevel;

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

    Route::middleware('access.level:4')->group(function () {
        Route::post('technic/getList', [TechnicController::class, 'getList']);
        Route::post('technic/getInfo', [TechnicController::class, 'getInfo']);
        Route::post('technic/move', [TechnicController::class, 'move']);

        Route::any('statement/get', [StatementController::class, 'get']);
        Route::post('statement/accept', [StatementController::class, 'accept']);
        Route::post('statement/complete', [StatementController::class, 'complete']);
    });

    Route::middleware('access.level:8')->group(function () {
        Route::post('technic/changeDescription', [TechnicController::class, 'changeDescription']);
        Route::post('technic/add', [TechnicController::class, 'add']);

        Route::post('user/getAllData', [UserController::class, 'getAllData']);
        Route::post('user/getInterval', [UserController::class, 'getInterval']);
        Route::post('user/delete', [UserController::class, 'delete']);
        Route::post('user/add', [UserController::class, 'add']);
    });
});

Route::get('test', function () {
    DB::enableQueryLog();

    $count = Repair::where('repairman_id', 2)->whereHas('report', function ($query) {
        $query->whereHas('user', function ($query)  {
            $query->select('id')->where('organization_id', 1);
        })->select('id')->where('status', 4)->whereBetween('complete_date', [1654732800, 1655251200]);
    })->count('id');
//    dd($count);
    dd(DB::getQueryLog());
});
