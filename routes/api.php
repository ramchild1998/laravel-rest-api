<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\VendorController;

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

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(RegisterController::class)->group(function() {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::get('/vendor', [VendorController::class, 'DataVendor'])
    ->middleware('auth:sanctum');

Route::post('/insert-vendor', [VendorController::class, 'InsertVendor'])
    ->middleware('auth:sanctum');

Route::get('/detail-vendor', [VendorController::class, 'DetailVendor'])
    ->middleware('auth:sanctum');

Route::post('/update-vendor', [VendorController::class, 'UpdateVendor'])
    ->middleware('auth:sanctum');
