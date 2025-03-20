<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\SensorController;

Route::group([
    'middleware' => 'throttle:60,1',
], function () {
    Route::post('/', [SensorController::class, 'store']);
    Route::get('/history', [SensorController::class, 'history']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
