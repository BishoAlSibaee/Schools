<?php

use App\Http\Controllers\ClassController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/getAllClassData', [ClassController::class, 'getAllClassData']);
Route::post('/getClassById', [ClassController::class, 'getClassById']);
Route::post('/insertClass', [ClassController::class, 'insertClass']);
Route::post('/deleteClass', [ClassController::class, 'deleteClass']);
Route::post('/ubdateClass', [ClassController::class, 'ubdateClass']);
