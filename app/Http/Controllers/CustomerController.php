<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    // -------------------------------------------------------
    // HOME PAGE
    // -------------------------------------------------------
    public function home()
    {
        $topRestaurantsSql = file_get_contents(database_path('sql/queries/customer/aggregate_top_restaurants.sql'));
        $topRestaurants = DB::select($topRestaurantsSql);

        $topOffersSql = file_get_contents(database_path('sql/queries/customer/get_top_offers.sql'));
        $topOffers = DB::select($topOffersSql);
        $topOffers = DB::select($topOffersSql);

        return view('home', compact('topRestaurants', 'topOffers'));
    }

    // -------------------------------------------------------
    // SEARCH SUGGESTIONS (AJAX)
    // -------------------------------------------------------
    public function searchSuggestions(Request $request)
    {
        $q = $request->input('q', '');
        if (strlen($q) < 2)
            return response()->json([]);

        $items = DB::select(
            "SELECT TOP 5 item_name AS label, 'item' AS type FROM menu_items
             WHERE item_name LIKE ? AND is_available = 1",
            ["%{$q}%"]
        );

        $restaurants = DB::select(
            "SELECT TOP 5 name AS label, 'restaurant' AS type FROM restaurants
             WHERE name LIKE ?",
            ["%{$q}%"]
        );

        $results = array_merge($items, $restaurants);
        // Remove duplicates by label
        $seen = [];
        $unique = [];
        foreach ($results as $r) {
            if (!in_array($r->label, $seen)) {
                $seen[] = $r->label;
                $unique[] = $r;
            }
        }
        return response()->json(array_slice($unique, 0, 8));
    }

    // -------------------------------------------------------
    // SEARCH RESULTS PAGE
    // -------------------------------------------------------
    public function search(Request $request)
    {
        $q = $request->input('q', '');
        $cuisines = DB::select("SELECT cuisine_id, cuisine_name FROM cuisine_types ORDER BY cuisine_name");
        $filterCuisines = $request->input('cuisine', []);
        $offersOnly = $request->input('offers_only', 0);
        $sort = $request->input('sort', 'popular');

        if (empty($q)) {
            return view('customer.search', [
                'query' => '',
                'items' => (new \Illuminate\Pagination\LengthAwarePaginator([], 0, 12)),
                'restaurants' => (new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10)),
                'cuisines' => $cuisines,
            ]);
        }

        // --- Items query ---
        $itemQuery = DB::table('menu_items as mi')
            ->leftJoin('offers as o', function ($j) {
                $j->on('o.target_item_id', '=', 'mi.item_id')
                    ->where('o.is_active', 1)
                    ->where('o.target_type', 'item')
                    ->whereRaw('GETDATE() BETWEEN o.start_datetime AND o.end_datetime');
            })
            ->leftJoin('cuisine_types as ct', 'mi.cuisine_id', '=', 'ct.cuisine_id')
            ->join('restaurants as r', 'mi.restaurant_id', '=', 'r.restaurant_id')
            ->select(
                'mi.item_id',
                'mi.item_name',
                'mi.item_image',
                'mi.description',
                'mi.price',
                DB::raw("CASE WHEN o.offer_id IS NOT NULL THEN ROUND(mi.price - (mi.price * o.discount_value / 100), 2) ELSE NULL END AS offer_price"),
                'ct.cuisine_name as cuisine_names',
                'ct.cuisine_id',
                'r.name as restaurant_name',
                DB::raw("(SELECT COUNT(*) FROM cart_items ci WHERE ci.item_id = mi.item_id) AS order_count")
            )
            ->where('mi.is_available', 1)
            ->where('mi.item_name', 'like', "%{$q}%");

        if (!empty($filterCuisines)) {
            $itemQuery->whereIn('mi.cuisine_id', $filterCuisines);
        }
        if ($offersOnly) {
            $itemQuery->whereNotNull('o.offer_id');
        }

        $itemQuery = match ($sort) {
            'price_asc' => $itemQuery->orderBy('mi.price'),
            'price_desc' => $itemQuery->orderByDesc('mi.price'),
            default => $itemQuery->orderByDesc('order_count'),
        };

        $items = $itemQuery->paginate(12, ['*'], 'item_page');

        // --- Restaurants query ---
        $restQuery = DB::table('restaurants as r')
            ->leftJoin('restaurant_ratings as rr', 'r.restaurant_id', '=', 'rr.restaurant_id')
            ->select(
                'r.restaurant_id',
                'r.name',
                'r.location',
                'r.cover_image',
                DB::raw("ISNULL(rr.avg_rating,0) AS avg_rating"),
                DB::raw("ISNULL(rr.total_reviews,0) AS total_reviews"),
                DB::raw("(SELECT COUNT(*) FROM orders o WHERE o.restaurant_id = r.restaurant_id) AS order_count")
            )
            ->where('r.name', 'like', "%{$q}%")
            ->orderByDesc('order_count');

        $restaurants = $restQuery->paginate(10, ['*'], 'rest_page');

        return view('customer.search', compact('q', 'items', 'restaurants', 'cuisines', 'sort'));
    }

    // -------------------------------------------------------
    // OFFERS PAGE
    // -------------------------------------------------------
    public function offers(Request $request)
    {
        $cuisines = DB::select("SELECT cuisine_id, cuisine_name FROM cuisine_types ORDER BY cuisine_name");
        $filterCuisines = $request->input('cuisine', []);

        $query = DB::table('menu_items as mi')
            ->join('offers as o', function ($j) {
                $j->on('o.target_item_id', '=', 'mi.item_id')
                    ->where('o.is_active', 1)->where('o.target_type', 'item')
                    ->whereRaw('GETDATE() BETWEEN o.start_datetime AND o.end_datetime');
            })
            ->join('restaurants as r', 'mi.restaurant_id', '=', 'r.restaurant_id')
            ->leftJoin('cuisine_types as ct', 'mi.cuisine_id', '=', 'ct.cuisine_id')
            ->select(
                'mi.item_id',
                'mi.item_name',
                'mi.item_image',
                'mi.description',
                'mi.price',
                DB::raw("ROUND(mi.price - (mi.price * o.discount_value / 100), 2) AS offer_price"),
                'ct.cuisine_name as cuisine_names',
                'mi.cuisine_id',
                'r.restaurant_id',
                'r.name as restaurant_name',
                'r.cover_image'
            )
            ->where('mi.is_available', 1);

        if (!empty($filterCuisines)) {
            $query->whereIn('mi.cuisine_id', $filterCuisines);
        }

        $paginatedItems = $query->paginate(24);
        $totalItems = $paginatedItems->total();

        // Group by restaurant for display
        $groupedOffers = [];
        foreach ($paginatedItems as $item) {
            $rid = $item->restaurant_id;
            if (!isset($groupedOffers[$rid])) {
                $groupedOffers[$rid] = [
                    'name' => $item->restaurant_name,
                    'cover_image' => $item->cover_image,
                    'items' => [],
                ];
            }
            $groupedOffers[$rid]['items'][] = $item;
        }

        return view('customer.offers', compact('groupedOffers', 'paginatedItems', 'cuisines', 'totalItems'));
    }

    // -------------------------------------------------------
    // PROFILE
    // -------------------------------------------------------
    public function profile()
    {
        $userId = session('user_id');
        $user = DB::table('users')->where('id', $userId)->first();
        $addresses = DB::table('customer_addresses')
            ->where('customer_id', $userId)
            ->orderByDesc('is_default')
            ->get();
        
        // Fetch all active delivery partners for testing selection
        $partners = DB::table('delivery_partner_profiles as dpp')
            ->join('users as u', 'dpp.partner_id', '=', 'u.id')
            ->select('u.id', 'u.name')
            ->where('u.is_active', 1)
            ->get();

        // Updated to use the same logic as orderHistory but limited to 3
        $recentOrders = DB::table('orders as o')
            ->join('restaurants as r', 'o.restaurant_id', '=', 'r.restaurant_id')
            ->leftJoin('deliveries as d', 'o.order_id', '=', 'd.order_id')
            ->leftJoin('reviews as rev', 'o.order_id', '=', 'rev.order_id')
            ->select('o.*', 'r.name as restaurant_name', 'd.partner_id', 'rev.review_id')
            ->where('o.customer_id', $userId)
            ->orderByDesc('o.order_datetime')
            ->limit(3)
            ->get();

        return view('customer.profile', compact('user', 'addresses', 'recentOrders', 'partners'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|max:100',
            'phone_number' => ['required', 'regex:/^01[0-9]{9}$/'],
        ]);

        $userId = session('user_id');
        $sql = file_get_contents(database_path('sql/queries/customer/update_profile.sql'));
        DB::statement($sql, [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone_number,
            'userId' => $userId,
        ]);

        return redirect()->route('customer_profile')->with('success', 'Profile updated successfully.');
    }

    // -------------------------------------------------------
    // ADDRESSES
    // -------------------------------------------------------
    public function storeAddress(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:50',
            'address_line' => 'required|string|max:255',
            'city' => 'required|string|max:100',
        ]);
        $userId = session('user_id');
        $sql = file_get_contents(database_path('sql/queries/auth/insert_address.sql'));
        DB::statement($sql, [$userId, $request->label, $request->address_line, $request->city, 0]);
        return redirect()->route('customer_profile')->with('success', 'Address added.');
    }

    public function updateAddress(Request $request, $id)
    {
        $request->validate([
            'label' => 'required|string|max:50',
            'address_line' => 'required|string|max:255',
            'city' => 'required|string|max:100',
        ]);
        $userId = session('user_id');
        $sql = file_get_contents(database_path('sql/queries/customer/update_address.sql'));
        DB::statement($sql, [
            'label' => $request->label,
            'addressLine' => $request->address_line,
            'city' => $request->city,
            'addressId' => $id,
            'customerId' => $userId,
        ]);
        return redirect()->route('customer_profile')->with('success', 'Address updated.');
    }

    public function setDefaultAddress($id)
    {
        $userId = session('user_id');
        DB::transaction(function () use ($id, $userId) {
            DB::statement(
                "UPDATE customer_addresses SET is_default = 0 WHERE customer_id = ?",
                [$userId]
            );
            DB::statement(
                "UPDATE customer_addresses SET is_default = 1 WHERE address_id = ? AND customer_id = ?",
                [$id, $userId]
            );
        });
        return redirect()->route('customer_profile')->with('success', 'Default address updated.');
    }

    public function deleteAddress($id)
    {
        $userId = session('user_id');
        $sql = file_get_contents(database_path('sql/queries/customer/delete_address.sql'));
        DB::statement($sql, ['addressId' => $id, 'customerId' => $userId]);
        return redirect()->route('customer_profile')->with('success', 'Address removed.');
    }

    // -------------------------------------------------------
    // ORDER HISTORY (full page)
    // -------------------------------------------------------
    public function orderHistory()
    {
        $userId = session('user_id');
        $sql = file_get_contents(database_path('sql/queries/customer/get_order_history.sql'));

        $allResults = DB::select($sql, [$userId]);

        // RE-ADDED for testing: Fetch all active delivery partners
        $partners = DB::table('delivery_partner_profiles as dpp')
            ->join('users as u', 'dpp.partner_id', '=', 'u.id')
            ->select('u.id', 'u.name')
            ->where('u.is_active', 1)
            ->get();

        // Manual pagination for DB::select results
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $perPage = 10;
        $currentItems = array_slice($allResults, ($currentPage - 1) * $perPage, $perPage);
        $orders = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentItems,
            count($allResults),
            $perPage,
            $currentPage,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );

        return view('customer.order_history', compact('orders', 'partners'));
    }

    // -------------------------------------------------------
    // DELETE ACCOUNT
    // -------------------------------------------------------
    public function deleteAccount(Request $request)
    {
        $userId = session('user_id');
        // Soft-delete: deactivate + mangle email & phone so the UNIQUE constraints
        // no longer block re-registration with the same credentials.
        // The DB trigger (trg_AfterAccountDeactivation) does the same thing as a
        // safety net, but we also handle it here in PHP to be sure.
        DB::statement(
            "UPDATE users
             SET is_active    = 0,
                 email        = CONCAT('deleted_', CAST(id AS VARCHAR), '_', email),
                 phone_number = '010' + RIGHT('00000000' + CAST(id AS VARCHAR(8)), 8)
             WHERE id = ? AND is_active = 1",
            [$userId]
        );
        Session::flush();
        return redirect()->route('login')->with('success', 'Your account has been deleted. You may register again anytime.');
    }
}