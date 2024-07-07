<?php

use App\Http\Controllers\ApiServiceController;
use App\Http\Controllers\Auth\LoginController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login', [ApiServiceController::class, 'apilogin']);

Route::middleware('auth.fixed')->group(function () {
    Route::get('/get-bin-details/{bin}',[ApiServiceController::class,'getBinDetails']);
    // Route::post('/save-building', [ApiServiceController::class,'getBuilding']);
    Route::post('/update-building/{bin}', [ApiServiceController::class,'updateBuilding']);

});



