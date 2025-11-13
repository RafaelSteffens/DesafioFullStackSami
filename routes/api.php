<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PersonController;

Route::get('/people', [PersonController::class, 'index']);
Route::post('/people', [PersonController::class, 'store']);
Route::put('/people/{person}', [PersonController::class, 'update']);
Route::patch('/people/{person}', [PersonController::class, 'update']);
Route::delete('/people/{person}', [PersonController::class, 'destroy']);


