<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

/* -------------------------------------------------------
 | DEFAULT ROUTE: always redirect to /login
 ------------------------------------------------------- */
Route::get('/', function () {
    if (!Session::has('user_id')) {
        return redirect()->route('login');
    }
    // Redirect to the correct dashboard based on role
    $role = Session::get('user_role');
    return match($role) {
        'restaurant_owner' => redirect()->route('owner.dashboard'),
        'delivery_partner' => redirect()->route('rider.dashboard'),
        default            => redirect()->route('home'),
    };
})->name('index');

/* -------------------------------------------------------
 | AUTHENTICATION ROUTES (guests only)
 ------------------------------------------------------- */
Route::view('/login',    'auth.login')->name('login');
Route::post('/login',    [AuthController::class, 'login']);

Route::view('/register', 'auth.register')->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

/* -------------------------------------------------------
 | PROTECTED ROUTES (requires login via custom.auth)
 ------------------------------------------------------- */
Route::middleware(['custom.auth'])->group(function () {

    // --- Customer ---
    Route::get('/customer/profile', function () {
        $userId = session('user_id');
        $user = DB::table('users')->where('id', $userId)->first();
        $profileData = DB::table('vw_customer_profile_by_id')
                        ->where('customer_id', $userId)->get();
        return view('customer.profile', compact('user', 'profileData'));
    })->name('customer_profile');

    // --- Owner ---
    Route::get('/owner/dashboard', function () {
        return view('owner.dashboard');
    })->name('owner.dashboard');

    // --- Rider ---
    Route::get('/rider/dashboard', function () {
        return view('rider.dashboard');
    })->name('rider.dashboard');

    // ---Restaurant ---
    Route::get('/restaurant/dashboard', function () {
        return view('restaurant.dashboard');
    })->name('restaurant.dashboard');

    Route::get('/restaurant/items', function () {
        return view('restaurant.items'); // create this blade file
    })->name('restaurant.items');

    Route::get('/restaurant/orders', function () {
        return view('restaurant.orders'); // create this blade file
    })->name('restaurant.orders');

    Route::get('/restaurant/analytics', function () {
        return view('restaurant.analytics'); // create this blade file
    })->name('restaurant.analytics');

    Route::get('/restaurant/add-item', function () {
        return view('restaurant.add_item');
    })->name('restaurant.add_item');

    Route::get('/restaurant/add-offer', function () {
        return view('restaurant.add_offer');
    })->name('restaurant.add_offer');

    Route::get('/restaurant/item/{id}', function ($id) {
        return view('restaurant.item_details', compact('id'));
    })->name('restaurant.item.details');


});

Route::post('/restaurant/store-item', function () {

    $name = request('name');
    $price = request('price');
    $category = request('category');
    $description = request('description');

    // For now just test
    return $name . " added successfully!";
    
})->name('restaurant.storeItem');


/* -------------------------------------------------------
 | PUBLIC HOMEPAGE (restaurants / cuisines browsing)
 ------------------------------------------------------- */
Route::get('/home', function () {
    $cuisines    = DB::table('vw_get_cuisines')->get();
    $restaurants = DB::table('vw_get_restaurants')->get();
    return view('home', compact('cuisines', 'restaurants'));
})->name('home');

require __DIR__.'/settings.php';