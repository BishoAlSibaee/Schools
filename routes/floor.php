<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FloorController;



Route::get('/getAllFloorData', [FloorController::class, 'getAllFloorData']);
Route::post('/getFloorById', [FloorController::class, 'getFloorById']);
Route::post('/insertFloor', [FloorController::class, 'insertFloor']);
Route::post('/deleteFloor', [FloorController::class, 'deleteFloor']);
Route::post('/ubdateFloor', [FloorController::class, 'ubdateFloor']);
