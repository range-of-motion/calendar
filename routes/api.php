<?php

use App\Http\Controllers\Api\AppointmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/appointments', [AppointmentController::class, 'index']);
Route::post('/appointments/{appointment}/update', [AppointmentController::class, 'update']);
