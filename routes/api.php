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
    //get building, rent, business details
    Route::get('/get-bin-details/{bin}','ApiServiceController@getBinDetails');
    //redirection to map
    Route::get('/redirect-to-map/{bin}', 'ApiServiceController@redirectToMap')->name('redirect-to-map');
    //update building details from shangrila
    Route::post('/update-building/{bin}','ApiServiceController@updateBuilding');
    // destory building if deleted from Shangrila
    Route::post('/delete-building/{bin}','ApiServiceController@deleteBuilding');

});



