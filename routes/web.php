<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RiderController;
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
    Route::post('/customer/reviews', [ReviewController::class, 'store'])->name('customer.review.store');

    // Customer account deletion
    Route::delete('/customer/account', [CustomerController::class, 'deleteAccount'])->name('customer.account.delete');

    Route::get('/restaurant-details/{id}', function (\Illuminate\Http\Request $request, $id) {
        $restaurant = DB::selectOne("EXEC sp_get_restaurant_by_id ?", [$id]);
        if (!$restaurant) abort(404);
        
        // Search, Category and Cuisine filters
        $search = $request->query('search');
        $categoryId = $request->query('category_id');
        $cuisineId = $request->query('cuisine_id');
        
        // Filtered items
        $items = DB::select("EXEC sp_search_menu_items ?, ?, ?, ?", [
            $id, 
            $categoryId,
            $search,
            $cuisineId
        ]);
        
        $categories = DB::select("EXEC sp_get_categories_by_restaurant ?", [$id]);
        $cuisines = DB::select("EXEC sp_get_cuisines_by_restaurant ?", [$id]);
        $offers = DB::select("EXEC sp_get_active_offers ?", [$id]);
        $reviews = DB::select("EXEC sp_get_recent_reviews ?", [$id]);

        return view('restaurant_detail', compact('restaurant', 'items', 'categories', 'cuisines', 'search', 'categoryId', 'cuisineId', 'offers', 'reviews'));
    })->name('restaurant.details');

    // --- Rider ---
    Route::get('/rider/dashboard', [RiderController::class, 'dashboard'])->name('rider.dashboard');
    Route::post('/rider/deliveries/accept', [RiderController::class, 'acceptDelivery'])->name('rider.deliveries.accept');
    Route::patch('/rider/deliveries/{id}/status', [RiderController::class, 'updateDeliveryStatus'])->name('rider.deliveries.status');
    Route::get('/rider/delivery-history', [RiderController::class, 'deliveryHistory'])->name('rider.delivery-history');
    Route::get('/rider/profile', [RiderController::class, 'profile'])->name('rider.profile');
    Route::put('/rider/profile', [RiderController::class, 'updateProfile'])->name('rider.profile.update');
    Route::put('/rider/vehicle', [RiderController::class, 'updateVehicle'])->name('rider.vehicle.update');
    Route::delete('/rider/account', [RiderController::class, 'deleteAccount'])->name('rider.account.delete');

    // --- Restaurant ---
    Route::get('/restaurant/dashboard', [RestaurantController::class, 'dashboard'])
        ->name('restaurant.dashboard');

    Route::get('/restaurant/items', [RestaurantController::class, 'items'])
        ->name('restaurant.items');

    Route::get('/restaurant/orders', [RestaurantController::class, 'orders'])
        ->name('restaurant.orders');

    Route::patch('/restaurant/orders/{id}/status', [RestaurantController::class, 'updateOrderStatus'])
        ->name('restaurant.updateOrderStatus');

    Route::get('/restaurant/analytics', [RestaurantController::class, 'analytics'])
        ->name('restaurant.analytics');

    Route::get('/restaurant/reviews', [RestaurantController::class, 'reviews'])
        ->name('restaurant.reviews');

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

    // --- Cart API Routes ---
    // Route::get('/api/cart', [App\Http\Controllers\CartController::class, 'getGlobalCart'])->name('cart.global');
    // Route::post('/api/cart/clear-all', [App\Http\Controllers\CartController::class, 'clearAllCarts'])->name('cart.clearAll');
    Route::get('/api/cart/{restaurantId}', [App\Http\Controllers\CartController::class, 'getCart'])->name('cart.get');
    Route::post('/api/cart/add', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/api/cart/update', [App\Http\Controllers\CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/api/cart/remove', [App\Http\Controllers\CartController::class, 'removeItem'])->name('cart.remove');
    Route::post('/api/cart/clear', [App\Http\Controllers\CartController::class, 'clearCart'])->name('cart.clear');

    // --- Checkout Routes ---
    Route::get('/checkout/{restaurantId}', [CheckoutController::class, 'showCheckout'])->name('checkout.show');
    Route::post('/checkout/{restaurantId}/place', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');

});

// Route::post('/restaurant/store-item', function () {

//     $name = request('name');
//     $price = request('price');
//     $category = request('category');
//     $description = request('description');

//     // For now just test
//     return $name . " added successfully!";
    
// })->name('restaurant.storeItem');
Route::post('/restaurant/store-item', [RestaurantController::class, 'storeItem'])
    ->name('restaurant.storeItem');

require __DIR__ . '/settings.php';
