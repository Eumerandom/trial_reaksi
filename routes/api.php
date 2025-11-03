<?php

use App\Http\Controllers\Api\ShareholdingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/shareholdings', ShareholdingController::class)
    ->name('api.shareholdings.show');

Route::get('/health', function () {
    return response()->json([
        "status" => "online"
    ]);
});