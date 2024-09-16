<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StageController;

Route::get('/getAllStageData', [StageController::class, 'getAllStageData']);
Route::post('/getStageById', [StageController::class, 'getStageById']);
Route::post('/insertStage', [StageController::class, 'insertStage']);
Route::post('/deleteStage', [StageController::class, 'deleteStage']);
Route::post('/ubdateStage', [StageController::class, 'ubdateStage']);
