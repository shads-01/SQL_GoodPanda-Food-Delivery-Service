<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

/* LOGIN & REGISTER PAGE */

Route::view('/login', 'auth.login')->name('login');
Route::view('/register','auth.register');

Route::view('/customer/login','auth.login');
Route::view('/owner/login','auth.login');

Route::view('/customer/register','auth.register');
Route::view('/owner/register','auth.register');

Route::view('/customer/profile', 'customer.profile')->name('customer_profile');


use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['custom.auth'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('/customer/profile', 'customer.profile')->name('customer_profile');
});

require __DIR__.'/settings.php';
