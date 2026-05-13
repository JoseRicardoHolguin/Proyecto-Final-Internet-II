<?php

use App\Http\Controllers\Api\TravelApiController;
use App\Http\Controllers\Api\PlaceApiController;
use App\Http\Controllers\Api\DocumentApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('travels', TravelApiController::class);
    Route::apiResource('places', PlaceApiController::class);
    Route::apiResource('documents', DocumentApiController::class);
});

Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
