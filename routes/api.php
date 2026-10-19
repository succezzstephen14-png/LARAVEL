<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\RecruitmentController;

// API routes for live frontend data
Route::get('/vehicles/available', [VehicleController::class, 'getAvailable']);
Route::get('/drivers/available', [DriverController::class, 'getAvailable']);
Route::get('/recruitments/open', [RecruitmentController::class, 'getOpen']);
