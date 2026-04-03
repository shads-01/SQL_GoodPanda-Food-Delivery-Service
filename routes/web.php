<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\DB;

// Home Page
Route::get('/', function () {
    $cuisines = DB::table('vw_get_cuisines')->get();
    $restaurants = DB::table('vw_get_restaurants')->get();
    return view('home', compact('cuisines', 'restaurants'));
})->name('home');

/* --- AUTHENTICATION ROUTES --- */

// Default /login and /register redirect to customer by default
Route::redirect('/login', '/customer/login')->name('login');
Route::redirect('/register', '/customer/register');

// Customer Auth Group
Route::prefix('customer')->group(function () {
    Route::view('/login', 'auth.login')->name('customer.login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', function () {
        return view('auth.register', ['role' => 'customer']);
    })->name('customer.register');
});

// Owner Auth Group
Route::prefix('owner')->group(function () {
    Route::view('/login', 'auth.login')->name('owner.login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', function () {
        return view('auth.register', ['role' => 'owner']);
    })->name('owner.register');
});

// Post Actions (Shared Controller)
Route::post('/login', [AuthController::class, 'login'])->name('auth.login.post');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/* --- PROTECTED ROUTES --- */

Route::middleware(['custom.auth'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    
    Route::get('/customer/profile', function () {
        $userId = session('user_id');
        $user = DB::table('users')->where('id', $userId)->first();
        $profileData = DB::table('vw_customer_profile_by_id')
                        ->where('customer_id', $userId)->get();
                        
        return view('customer.profile', compact('user', 'profileData'));
    })->name('customer_profile');
});

require __DIR__.'/settings.php';