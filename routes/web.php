<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $cuisines = \Illuminate\Support\Facades\DB::table('vw_get_cuisines')->get();
    $restaurants = \Illuminate\Support\Facades\DB::table('vw_get_restaurants')->get();
    return view('home', compact('cuisines', 'restaurants'));
})->name('home');

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
    
    Route::get('/customer/profile', function () {
        $userId = session('user_id');
        
        $user = \Illuminate\Support\Facades\DB::table('users')->where('id', $userId)->first();
        
        // Use the view for profile info (addresses etc)
        $profileData = \Illuminate\Support\Facades\DB::table('vw_customer_profile_by_id')
                        ->where('customer_id', $userId)->get();
                        
        return view('customer.profile', compact('user', 'profileData'));
    })->name('customer_profile');
});

require __DIR__.'/settings.php';
