<?php

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
    Route::post('getEquipmentList', [EquipmentController::class, 'getEquipmentList']);
    Route::post('getEquipmentInfo', [EquipmentController::class, 'getEquipmentInfo']);
});
