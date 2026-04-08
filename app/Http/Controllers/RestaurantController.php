<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;

class RestaurantController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $ownerId = session('user_id');

        $restaurant = DB::table('restaurants')
            ->where('owner_id', $ownerId)
            ->first();

        if (!$restaurant) {
            return redirect()->route('home')->with('error', 'No restaurant found for your account. Please contact support.');
        }

        $rid = $restaurant->restaurant_id;

        // --- Basic counts ---
        $itemCount = DB::table('menu_items')->where('restaurant_id', $rid)->count();
        $availableItems = DB::table('menu_items')->where('restaurant_id', $rid)->where('is_available', 1)->count();
        $unavailableItems = DB::table('menu_items')->where('restaurant_id', $rid)->where('is_available', 0)->count();

        // --- Active offers ---
        $activeOffers = DB::table('offers')
            ->leftJoin('menu_items', 'offers.target_item_id', '=', 'menu_items.item_id')
            ->where('offers.restaurant_id', $rid)
            ->where('offers.is_active', 1)
            ->where('offers.start_datetime', '<=', DB::raw('GETDATE()'))
            ->where('offers.end_datetime', '>=', DB::raw('GETDATE()'))
            ->select('offers.*', 'menu_items.item_name')
            ->orderBy('offers.created_at', 'desc')
            ->get();
        $itemsWithOffers = $activeOffers->unique('target_item_id')->count();

        // --- 1. Top Selling Items ---
        $topItems = DB::select(
            file_get_contents(database_path('sql/queries/restaurant/dashboard_top_items.sql')),
            [$rid]
        );

        // --- 2. Revenue & Order Stats (COUNT + SUM + Scalar Subquery) ---
        $revenueStats = DB::select(
            file_get_contents(database_path('sql/queries/restaurant/dashboard_revenue_stats.sql')),
            [$rid, $rid]
        );
        $stats = $revenueStats[0] ?? null;

        // --- 3. Recent Orders (JOIN) ---
        $recentOrders = DB::select(
            file_get_contents(database_path('sql/queries/restaurant/dashboard_recent_orders.sql')),
            [$rid]
        );

        // --- 4. Active/Pending Orders (IN clause) ---
        $activeOrders = DB::select(
            file_get_contents(database_path('sql/queries/restaurant/dashboard_active_orders.sql')),
            [$rid]
        );

        // --- 5. Recent Reviews (JOIN + Scalar Subquery) ---
        $recentReviews = DB::select(
            file_get_contents(database_path('sql/queries/restaurant/dashboard_recent_reviews.sql')),
            [$rid, $rid]
        );

        return view('restaurant.dashboard', compact(
            'restaurant',
            'itemCount',
            'availableItems',
            'unavailableItems',
            'activeOffers',
            'itemsWithOffers',
            'topItems',
            'stats',
            'recentOrders',
            'activeOrders',
            'recentReviews'
        ));
    }

    // Add Item Page
    public function addItem()
    {
        $ownerId = session('user_id');

        $restaurant = DB::table('restaurants')
            ->where('owner_id', $ownerId)
            ->first();

        if (!$restaurant) {
            return redirect()->route('home')->with('error', 'No restaurant found for your account. Please contact support.');
        }

        $categories = DB::table('menu_categories')
            ->where('restaurant_id', $restaurant->restaurant_id)
            ->get();

        $cuisines = DB::table('cuisine_types')->get();

        return view('restaurant.add_item', compact('categories', 'cuisines'));
    }

    // Store Item
    public function storeItem(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|integer',
            'cuisine_id' => 'required|integer',
            'description' => 'nullable|string|max:500',
            'item_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $ownerId = session('user_id');
        $restaurant = DB::table('restaurants')->where('owner_id', $ownerId)->first();

        if (!$restaurant) {
            return redirect()->route('home')->with('error', 'No restaurant found for your account.');
        }

        // 1. Handle Image Upload to Cloudinary
        $itemImageUrl = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=600&auto=format&fit=crop'; // Default placeholder

        if ($request->hasFile('item_image')) {
            try {
                $file = $request->file('item_image');
                $cloudName = env('CLOUDINARY_CLOUD_NAME');
                $apiKey = env('CLOUDINARY_API_KEY');
                $apiSecret = env('CLOUDINARY_API_SECRET');
                $timestamp = time();
                $folder = 'goodpanda/menu_items';

                $paramsToSign = "folder={$folder}&timestamp={$timestamp}";
                $signature = sha1($paramsToSign . $apiSecret);

                $ch = curl_init("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload");
                curl_setopt_array($ch, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => [
                        'file' => new \CURLFile($file->getRealPath(), $file->getMimeType(), $file->getClientOriginalName()),
                        'api_key' => $apiKey,
                        'timestamp' => $timestamp,
                        'folder' => $folder,
                        'signature' => $signature,
                    ],
                ]);

                $response = curl_exec($ch);
                curl_close($ch);

                $result = json_decode($response, true);
                if (isset($result['secure_url'])) {
                    $itemImageUrl = $result['secure_url'];
                } else {
                    dd([
                        'error_message' => 'Cloudinary Item Upload returned no URL', 
                        'raw_response' => $response,
                        'cloudConfig' => compact('cloudName', 'apiKey', 'apiSecret'),
                        'payload' => $paramsToSign
                    ]);
                    \Illuminate\Support\Facades\Log::warning('Cloudinary Item Upload returned no URL: ' . $response);
                }
            } catch (\Throwable $e) {
                dd('Exception thrown during upload:', $e->getMessage());
                \Illuminate\Support\Facades\Log::error('Cloudinary Item Upload failed: ' . $e->getMessage());
            }
        }

        // 2. Insert into database
        DB::table('menu_items')->insert([
            'restaurant_id' => $restaurant->restaurant_id,
            'category_id' => $request->category_id,
            'cuisine_id' => $request->cuisine_id,
            'item_name' => $request->name,
            'description' => $request->description,
            'item_image' => $itemImageUrl,
            'price' => $request->price,
            'is_available' => 1,
            'created_at' => now(),
        ]);

        return redirect()->route('restaurant.items')
            ->with('success', 'Item added successfully!');
    }

    // Items List
    public function items()
    {
        $ownerId = session('user_id');

        $restaurant = DB::table('restaurants')
            ->where('owner_id', $ownerId)
            ->first();

        if (!$restaurant) {
            return redirect()->route('home')->with('error', 'No restaurant found for your account. Please contact support.');
        }

        // Get items using stored procedure
        $items = collect(DB::select("EXEC sp_get_items_by_res_id ?", [$restaurant->restaurant_id]));

        // Get active offers for these items
        $itemIds = $items->pluck('item_id');
        $offers = DB::table('offers')
            ->whereIn('target_item_id', $itemIds)
            ->where('target_type', 'item')
            ->where('is_active', 1)
            ->where('start_datetime', '<=', DB::raw('GETDATE()'))
            ->where('end_datetime', '>=', DB::raw('GETDATE()'))
            ->select('target_item_id', 'discount_type', 'discount_value', 'offer_title')
            ->get()
            ->keyBy('target_item_id');

        // Attach offer data to items
        foreach ($items as $item) {
            $offer = $offers->get($item->item_id);
            $item->original_price = $item->price;
            if ($offer) {
                $item->discount_type = $offer->discount_type;
                $item->discount_value = $offer->discount_value;
                $item->offer_title = $offer->offer_title;
                if ($offer->discount_type === 'percentage' && $offer->discount_value) {
                    $item->discounted_price = $item->price - ($item->price * $offer->discount_value / 100);
                } elseif ($offer->discount_type === 'flat' && $offer->discount_value) {
                    $item->discounted_price = max(0, $item->price - $offer->discount_value);
                } else {
                    $item->discounted_price = $item->price;
                }
                $item->has_offer = true;
            } else {
                $item->discounted_price = $item->price;
                $item->has_offer = false;
            }
        }

        return view('restaurant.items', compact('items'));
    }

    // Add Offer Page
    public function addOffer()
    {
        $ownerId = session('user_id');

        $restaurant = DB::table('restaurants')
            ->where('owner_id', $ownerId)
            ->first();

        if (!$restaurant) {
            return redirect()->route('home')->with('error', 'No restaurant found for your account. Please contact support.');
        }

        $items = DB::table('menu_items')
            ->where('restaurant_id', $restaurant->restaurant_id)
            ->select('item_id', 'item_name')
            ->get();

        $categories = DB::table('menu_categories')
            ->where('restaurant_id', $restaurant->restaurant_id)
            ->select('category_id', 'category_name')
            ->get();

        return view('restaurant.add_offer', compact('items', 'categories'));
    }

    // Store Offer
    public function storeOffer(Request $request)
    {
        $request->validate([
            'offer_title' => 'required|string|min:3|max:150',
            'discount_type' => 'required|in:percentage,flat,free_delivery',
            'discount_value' => 'nullable|numeric|min:0.01',
            'target_type' => 'required|in:item,category,restaurant',
            'target_item_id' => 'nullable|integer',
            'target_category_id' => 'nullable|integer',
            'min_order_amount' => 'nullable|numeric|min:1',
            'start_date' => 'required|date|before:-1 day',
            'end_date' => 'required|date',
        ]);

        // Enforcement of discount requirements
        if ($request->discount_type !== 'free_delivery' && empty($request->discount_value)) {
            return redirect()->back()->withErrors(['discount_value' => 'Discount value is required for this type.']);
        }
        
        // Enforcement of target requirements
        if ($request->target_type === 'item' && empty($request->target_item_id)) {
            return redirect()->back()->withErrors(['target_item_id' => 'An item must be selected.']);
        }
        if ($request->target_type === 'category' && empty($request->target_category_id)) {
            return redirect()->back()->withErrors(['target_category_id' => 'A category must be selected.']);
        }

        // Target nullification
        $targetItemId = $request->target_type === 'item' ? $request->target_item_id : null;
        $targetCategoryId = $request->target_type === 'category' ? $request->target_category_id : null;
        $discountValue = $request->discount_type === 'free_delivery' ? null : $request->discount_value;

        // Additional validation for date comparison
        $startDateTime = new \DateTime($request->start_date);
        $endDateTime = new \DateTime($request->end_date);
        $now = new \DateTime();

        if ($endDateTime <= $startDateTime) {
            return redirect()->back()->withErrors(['end_date' => 'End date must be after start date.']);
        }
 
        $ownerId = session('user_id');

        $restaurant = DB::table('restaurants')
            ->where('owner_id', $ownerId)
            ->first();

        if (!$restaurant) {
            return redirect()->route('home')->with('error', 'No restaurant found for your account.');
        }

        // Format dates for SQL Server requirements
        $startDate = $startDateTime->format('Y-m-d H:i:s');
        $endDate = $endDateTime->format('Y-m-d H:i:s');

        $sqlPath = base_path('database/sql/queries/insert_offer.sql');
        
        if (!file_exists($sqlPath)) {
            return redirect()->back()->with('error', 'SQL script for inserting offers not found.');
        }

        try {
            $sql = file_get_contents($sqlPath);
            
            DB::insert($sql, [
                $restaurant->restaurant_id,
                $request->offer_title,
                $request->discount_type,
                $discountValue,
                $request->target_type,
                $targetItemId,
                $targetCategoryId,
                $request->min_order_amount,
                $startDate,
                $endDate
            ]);

            return redirect()->route('restaurant.items')
                ->with('success', 'Offer created successfully!');
                
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Offer insertion failed: " . $e->getMessage());
            return redirect()->back()->with('error', 'Database Error: Could not save the offer.');
        }
    }

    // Edit Item Page
    public function editItem($id)
    {
        $ownerId = session('user_id');

        $restaurant = DB::table('restaurants')
            ->where('owner_id', $ownerId)
            ->first();

        if (!$restaurant) {
            return redirect()->route('home')->with('error', 'No restaurant found for your account. Please contact support.');
        }

        $item = DB::table('menu_items')
            ->leftJoin('menu_categories', 'menu_items.category_id', '=', 'menu_categories.category_id')
            ->where('menu_items.item_id', $id)
            ->where('menu_items.restaurant_id', $restaurant->restaurant_id)
            ->select('menu_items.*', 'menu_categories.category_name')
            ->first();

        if (!$item) {
            return redirect()->route('restaurant.items')->with('error', 'Item not found.');
        }

        $categories = DB::table('menu_categories')
            ->where('restaurant_id', $restaurant->restaurant_id)
            ->get();

        return view('restaurant.item_details', compact('item', 'categories'));
    }

    // Update Item
    public function updateItem(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|integer',
            'description' => 'nullable|string|max:500',
        ]);

        $ownerId = session('user_id');

        $restaurant = DB::table('restaurants')
            ->where('owner_id', $ownerId)
            ->first();

        if (!$restaurant) {
            return redirect()->route('home')->with('error', 'No restaurant found for your account. Please contact support.');
        }

        // Check if item belongs to this restaurant
        $item = DB::table('menu_items')
            ->where('item_id', $id)
            ->where('restaurant_id', $restaurant->restaurant_id)
            ->first();

        if (!$item) {
            return redirect()->route('restaurant.items')->with('error', 'Item not found.');
        }

        DB::table('menu_items')
            ->where('item_id', $id)
            ->update([
                'item_name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'category_id' => $request->category_id,
            ]);

        return redirect()->route('restaurant.items')
            ->with('success', 'Item updated successfully!');
    }

    // Orders List
    public function orders()
    {
        $ownerId = session('user_id');

        $restaurant = DB::table('restaurants')
            ->where('owner_id', $ownerId)
            ->first();

        if (!$restaurant) {
            return redirect()->route('home')->with('error', 'No restaurant found for your account.');
        }

        $orders = DB::select(
            file_get_contents(database_path('sql/queries/restaurant/get_all_orders.sql')),
            [$restaurant->restaurant_id]
        );

        return view('restaurant.orders', compact('orders'));
    }

    // Delete Item
    public function deleteItem($id)
    {
        $ownerId = session('user_id');

        $restaurant = DB::table('restaurants')
            ->where('owner_id', $ownerId)
            ->first();

        if (!$restaurant) {
            return redirect()->route('home')->with('error', 'No restaurant found for your account. Please contact support.');
        }

        // Check if item belongs to this restaurant
        $item = DB::table('menu_items')
            ->where('item_id', $id)
            ->where('restaurant_id', $restaurant->restaurant_id)
            ->first();

        if (!$item) {
            return redirect()->route('restaurant.items')->with('error', 'Item not found.');
        }

        DB::table('menu_items')
            ->where('item_id', $id)
            ->delete();

        return redirect()->route('restaurant.items')
            ->with('success', 'Item deleted successfully!');
    }
}