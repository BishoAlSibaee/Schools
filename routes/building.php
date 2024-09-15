<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuildingController;


Route::get('/getAllBuildingData', [BuildingController::class,'getAllBuildingData']);
Route::post('/insertBuilding', [BuildingController::class,'insertBuilding']);
Route::post('/getBuildingById', [BuildingController::class,'getBuildingById']);
Route::post('/deleteBuilding', [BuildingController::class,'deleteBuilding']);