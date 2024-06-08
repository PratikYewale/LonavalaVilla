<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\Admin\AdminAuthController;
use App\Http\Controllers\v1\Customer\CustAuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1/admin', 'as' => 'v1/admin'], function () {

    Route::post('adminRegister', [AdminAuthController::class, 'adminRegister']);
    Route::post('adminLogin', [AdminAuthController::class, 'adminLogin']);

    Route::group(['middleware' => ['cors', 'jwt.verify', 'admin']], function () {

        Route::get('getStudentStatus', [AdminAuthController::class, 'getStudentStatus']);
        Route::post('updateApproveStatus', [AdminAuthController::class, 'updateApproveStatus']);
    });
});

Route::group(['prefix' => 'v1/customer', 'as' => 'v1/customer'], function () {

    Route::post('custRegister', [CustAuthController::class, 'custRegister']);
    Route::Post('checkOtpAndLoginEmail', [CustAuthController::class, 'checkOtpAndLoginEmail']);
    Route::Post('custLogin', [CustAuthController::class, 'custLogin']);
});
