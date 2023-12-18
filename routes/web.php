<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Call API
Route::get('/view/detail/users',[RegisterController::class, 'index'])->name('view/detail/users');

// Login API
Route::get('login', [RegisterController::class, 'index'])->name('login');
