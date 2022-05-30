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

    Route::post('technic/getList', [TechnicController::class, 'getList']);
    Route::post('technic/getInfo', [TechnicController::class, 'getInfo']);

    Route::any('statement/get', [StatementController::class, 'get']);
    Route::post('statement/accept', [StatementController::class, 'accept']);
    Route::post('statement/complete', [StatementController::class, 'complete']);
});

Route::get('test', function () {
    DB::enableQueryLog();

//    $reports = Report::whereTechnicId(2)->where('status', 4)->get(); // Отобрать только готовые ремонты
//
//    $reportIds = [];
//    $userIds = [];
//    foreach ($reports as $report) {
//        $reportIds[] = $report->id;
//        if (!in_array($report->user_id, $userIds)) $userIds[] = $report->user_id;
//    }
//
//    $repairs = Repair::whereIn('report_id', $reportIds)->get();
//
//    foreach ($repairs as $repair) {
//        if (!in_array($repair->repairman_id, $userIds)) $userIds[] = $repair->repairman_id;
//    };
//
//    $users = User::whereOrganizationId(1)->whereIn('id', $userIds)->get();
//
//    $userNames = [];
//    foreach ($users as $user) $userNames[$user->id] = $user->lastname . ' ' . $user->firstname;
//
//    $reportRow = [];
//    foreach ($reports as $report) $reportRow[$report->id] = $report;
//
//    $repairMass = [];
//    foreach ($repairs as $repair) {
//        $repairMass[] = [
//            'id' => $repair->id,
//            'user' => $userNames[$reportRow[$repair->id]->user_id],
//            'repairman' => $userNames[$repair->repairman_id],
//            'userDescription' => $reportRow[$repair->id]->description,
//            'repairmanDescription' => $repair->description,
//            'startDate' => $reportRow[$repair->id]->create_date,
//            'endDate' => $reportRow[$repair->id]->complete_date
//        ];
//    }

//    dd([$movingMass, $repairMass]);
    dd(DB::getQueryLog());
});
