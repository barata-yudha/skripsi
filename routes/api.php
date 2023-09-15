<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'as' => 'v1.'], function() {
    // GIS route
    Route::group(['prefix' => 'tracking', 'as' => 'tracking.'], function(){
        Route::post('/get_tracking_odp', [App\Http\Controllers\API\TrackingDataController::class, 'get_tracking_odp'])->name('get_tracking_odp');
        Route::post('/get_tracking_timeslot', [App\Http\Controllers\API\TrackingDataController::class, 'get_tracking_timeslot'])->name('get_tracking_timeslot');

    });
});
