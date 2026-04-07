<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

/* -------------------------------------------------------
 | DEFAULT ROUTE: always redirect to /login
 ------------------------------------------------------- */

Route::get('/', function () {
    if (!Session::has('user_id')) {
        return redirect()->route('login');
    }
    $role = Session::get('user_role');
    return match ($role) {
        'restaurant_owner' => redirect()->route('restaurant.dashboard'),
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
 | PUBLIC ROUTES (no login required)
 ------------------------------------------------------- */

// Homepage — now served by CustomerController
Route::get('/home', [CustomerController::class, 'home'])->name('home');

// Search — accessible to guests too
Route::get('/search',             [CustomerController::class, 'search'])->name('customer.search');
Route::get('/search/suggestions', [CustomerController::class, 'searchSuggestions'])->name('customer.search.suggestions');
Route::get('/offers',             [CustomerController::class, 'offers'])->name('customer.offers');

/* -------------------------------------------------------
 | PROTECTED ROUTES (requires login via custom.auth)
 ------------------------------------------------------- */
Route::middleware(['custom.auth'])->group(function () {

    // --- Customer Profile ---
    Route::get('/customer/profile', [CustomerController::class, 'profile'])->name('customer_profile');

    // Customer profile update
    Route::put('/customer/profile', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');

    // Customer addresses
    Route::post('/customer/address',              [CustomerController::class, 'storeAddress'])->name('customer.address.store');
    Route::put('/customer/address/{id}',          [CustomerController::class, 'updateAddress'])->name('customer.address.update');
    Route::post('/customer/address/{id}/default', [CustomerController::class, 'setDefaultAddress'])->name('customer.address.default');
    Route::delete('/customer/address/{id}',       [CustomerController::class, 'deleteAddress'])->name('customer.address.destroy');

    // Customer order history (full page)
    Route::get('/customer/orders', [CustomerController::class, 'orderHistory'])->name('customer.order_history');

    // Customer account deletion
    Route::delete('/customer/account', [CustomerController::class, 'deleteAccount'])->name('customer.account.delete');

    // --- Rider ---
    Route::get('/rider/dashboard', function () {
        return view('rider.dashboard');
    })->name('rider.dashboard');

    // --- Restaurant ---
    Route::get('/restaurant/dashboard', [RestaurantController::class, 'dashboard'])
        ->name('restaurant.dashboard');

    Route::get('/restaurant/items', [RestaurantController::class, 'items'])
        ->name('restaurant.items');

    Route::get('/restaurant/orders', function () {
        return view('restaurant.orders');
    })->name('restaurant.orders');

    Route::get('/restaurant/analytics', function () {
        return view('restaurant.analytics');
    })->name('restaurant.analytics');

    Route::get('/restaurant/add-item', [RestaurantController::class, 'addItem'])
        ->name('restaurant.add_item');

    Route::get('/restaurant/add-offer', [RestaurantController::class, 'addOffer'])
        ->name('restaurant.add_offer');

    Route::post('/restaurant/store-offer', [RestaurantController::class, 'storeOffer'])
        ->name('restaurant.store_offer');

    Route::get('/restaurant/item/{id}', [RestaurantController::class, 'editItem'])
        ->name('restaurant.item.details');

    Route::put('/restaurant/item/{id}', [RestaurantController::class, 'updateItem'])
        ->name('restaurant.updateItem');

    Route::delete('/restaurant/item/{id}', [RestaurantController::class, 'deleteItem'])
        ->name('restaurant.deleteItem');
});

Route::post('/restaurant/store-item', [RestaurantController::class, 'storeItem'])
    ->name('restaurant.storeItem');

require __DIR__ . '/settings.php';
