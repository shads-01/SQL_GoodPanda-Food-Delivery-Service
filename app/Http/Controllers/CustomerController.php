<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class CustomerController extends Controller
{
    /**
     * Helper – load a raw SQL file from the customer queries folder.
     */
    private function getQuery(string $filename): string
    {
        return file_get_contents(database_path('sql/queries/customer/' . $filename));
    }

    /**
     * Helper – manual array-based pagination for raw SQL result sets.
     * Replaces Laravel's ->paginate() which only works with QueryBuilder.
     */
    private function manualPaginate(array $results, int $perPage, string $pageName = 'page'): LengthAwarePaginator
    {
        $page = Paginator::resolveCurrentPage($pageName);
        $total = count($results);
        $items = array_slice($results, ($page - 1) * $perPage, $perPage);

        return new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            ['path' => request()->url(), 'pageName' => $pageName, 'query' => request()->query()]
        );
    }

    // -------------------------------------------------------
    // HOME PAGE (uses aggregate_top_restaurants.sql + get_top_offers.sql)
    // -------------------------------------------------------
    public function home()
    {
        $topRestaurantsSql = $this->getQuery('aggregate_top_restaurants.sql');
        $topRestaurants = DB::select($topRestaurantsSql);

        $topOffersSql = $this->getQuery('get_top_offers.sql');
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
    // SEARCH RESULTS PAGE (uses search_items_restaurants.sql + search_restaurants.sql)
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
                'query' => '',
                'items' => new LengthAwarePaginator([], 0, 12),
                'restaurants' => new LengthAwarePaginator([], 0, 10),
                'cuisines' => $cuisines,
            ]);
        }

        // --- Items: load SQL file and append dynamic conditions ---
        $itemSql = $this->getQuery('search_items_restaurants.sql');
        $itemParams = ["%{$q}%", $offersOnly];

        if (!empty($filterCuisines)) {
            $placeholders = implode(',', array_fill(0, count($filterCuisines), '?'));
            $itemSql .= " AND mi.cuisine_id IN ({$placeholders})";
            $itemParams = array_merge($itemParams, $filterCuisines);
        }

        // Dynamic sort appended to the raw SQL
        $itemSql .= match ($sort) {
            'price_asc' => ' ORDER BY mi.price ASC',
            'price_desc' => ' ORDER BY mi.price DESC',
            default => ' ORDER BY order_count DESC',
        };

        $allItems = DB::select($itemSql, $itemParams);
        $items = $this->manualPaginate($allItems, 12, 'item_page');

        // --- Restaurants: load SQL file ---
        $restSql = $this->getQuery('search_restaurants.sql');
        $allRestaurants = DB::select($restSql, ["%{$q}%"]);
        $restaurants = $this->manualPaginate($allRestaurants, 10, 'rest_page');

        return view('customer.search', compact('q', 'items', 'restaurants', 'cuisines', 'sort'));
        return view('customer.search', compact('q', 'items', 'restaurants', 'cuisines', 'sort'));
    }

    // -------------------------------------------------------
    // OFFERS PAGE (uses get_offers_page.sql)
    // -------------------------------------------------------
    public function offers(Request $request)
    {
        $cuisines = DB::select("SELECT cuisine_id, cuisine_name FROM cuisine_types ORDER BY cuisine_name");
        $filterCuisines = $request->input('cuisine', []);

        // Load base SQL and append dynamic cuisine filter
        $sql = $this->getQuery('get_offers_page.sql');
        $params = [];

        if (!empty($filterCuisines)) {
            $placeholders = implode(',', array_fill(0, count($filterCuisines), '?'));
            $sql .= " AND mi.cuisine_id IN ({$placeholders})";
            $params = $filterCuisines;
        }

        $sql .= ' ORDER BY r.restaurant_id, mi.item_name';

        $allResults = DB::select($sql, $params);
        $totalItems = count($allResults);

        // Paginate
        $paginatedItems = $this->manualPaginate($allResults, 24);

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
        return view('customer.offers', compact('groupedOffers', 'paginatedItems', 'cuisines', 'totalItems'));
    }

    // -------------------------------------------------------
    // PROFILE (uses get_user_by_id.sql, get_customer_addresses.sql, get_recent_orders.sql)
    // -------------------------------------------------------
    public function profile()
    {
        $userId = session('user_id');
        $user = DB::selectOne($this->getQuery('get_user_by_id.sql'), [$userId]);
        $addresses = collect(DB::select($this->getQuery('get_customer_addresses.sql'), [$userId]));
        $recentOrders = collect(DB::select($this->getQuery('get_recent_orders.sql'), [$userId]));

        return view('customer.profile', compact('user', 'addresses', 'recentOrders'));
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
        $sqlFile = $this->getQuery('set_default_address.sql');

        // Strip comment-only lines to avoid PDO parameter confusion, then split on ;
        $cleanSql = implode("\n", array_filter(
            explode("\n", $sqlFile),
            fn($line) => !str_starts_with(trim($line), '--')
        ));
        $statements = array_values(array_filter(
            array_map('trim', explode(';', $cleanSql)),
            fn($s) => !empty($s)
        ));

        DB::transaction(function () use ($statements, $id, $userId) {
            DB::statement($statements[0], [$userId]);       // Clear all defaults
            DB::statement($statements[1], [$id, $userId]);  // Set new default
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
    // ORDER HISTORY (uses get_customer_orders.sql)
    // -------------------------------------------------------
    public function orderHistory()
    {
        $userId = session('user_id');
        $sql = $this->getQuery('get_customer_orders.sql');
        $allOrders = DB::select($sql, [$userId]);
        $orders = $this->manualPaginate($allOrders, 10);

        return view('customer.order_history', compact('orders'));
    }

    // -------------------------------------------------------
    // DELETE ACCOUNT (uses soft_delete_account.sql)
    // -------------------------------------------------------
    public function deleteAccount(Request $request)
    {
        $userId = session('user_id');
        $sql = $this->getQuery('soft_delete_account.sql');
        DB::statement($sql, [$userId]);
        Session::flush();
        return redirect()->route('login')->with('success', 'Your account has been deleted. You may register again anytime.');
    }
}