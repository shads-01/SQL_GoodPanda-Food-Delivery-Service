<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

/* LOGIN & REGISTER PAGE */

Route::view('/login', 'auth.login')->name('login');
Route::view('/register','auth.register');

Route::view('/customer/login','auth.login');
Route::view('/owner/login','auth.login');

Route::view('/customer/register','auth.register');
Route::view('/owner/register','auth.register');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
