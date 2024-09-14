<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/getAllBuildingData', 'App\Http\Controllers\BuildingController@getAllBuildingData');
Route::post('/insertBuilding', 'App\Http\Controllers\BuildingController@insertBuilding');
Route::post('/getBuildingById', 'App\Http\Controllers\BuildingController@getBuildingById');
Route::post('/deleteBuilding', 'App\Http\Controllers\BuildingController@deleteBuilding');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
