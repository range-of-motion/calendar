<?php

use App\Http\Controllers\Api\AppointmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/appointments', [AppointmentController::class, 'index']);
Route::put('/appointments/{appointment}', [AppointmentController::class, 'update']);
