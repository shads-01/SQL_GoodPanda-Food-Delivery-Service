<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

/* ROLE-SPECIFIC LOGIN & REGISTER PAGES (Fortify handles the main /login and /register routes) */

Route::view('/customer/login', 'auth.login');
Route::view('/owner/login', 'auth.login');

Route::view('/customer/register', 'auth.register');
Route::view('/owner/register', 'auth.register');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
