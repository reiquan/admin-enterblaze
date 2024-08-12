<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthApiController;
use App\Http\Controllers\API\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('user', function (Request $request) {
    return $request->user();
});

// Public routes
Route::post('loginSubscriber', [AuthApiController::class, 'loginSubscriber']);
Route::post('registerSubscriber', [AuthApiController::class, 'registerSubscriber']);
Route::post('getUniverses', [ApiController::class, 'getUniverses']);
Route::post('logoutSubscriber', [AuthApiController::class, 'logoutSubscriber']);

// Protected routes
Route::middleware(['auth:sanctum', 'checkTokenExpiration'])->group(function () {
    // Route::get('/profile', 'UserProfileController@show');

});
