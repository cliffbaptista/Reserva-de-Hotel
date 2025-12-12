<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\GuestController;
use App\Http\Controllers\Api\SeasonController;
use App\Http\Controllers\Api\ReservationController;

Route::apiResource('rooms', RoomController::class);
Route::apiResource('guests', GuestController::class);
Route::apiResource('seasons', SeasonController::class);
Route::apiResource('reservations', ReservationController::class);

Route::post('reservations/{id}/cancel', [ReservationController::class, 'cancel']);