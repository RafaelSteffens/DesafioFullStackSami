<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PersonController;

Route::get('ping', function () {
    return response()->json(['message' => 'API OK']);
});

Route::apiResource('people', PersonController::class)->only([
    'index',
    'store',
    'update',
    'destroy',
]);
