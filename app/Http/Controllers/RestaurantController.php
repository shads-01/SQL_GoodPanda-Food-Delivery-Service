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

        $itemCount = DB::table('menu_items')
            ->where('restaurant_id', $restaurant->restaurant_id)
            ->count();

        // Get additional dashboard data
        $availableItems = DB::table('menu_items')
            ->where('restaurant_id', $restaurant->restaurant_id)
            ->where('is_available', 1)
            ->count();

        $unavailableItems = DB::table('menu_items')
            ->where('restaurant_id', $restaurant->restaurant_id)
            ->where('is_available', 0)
            ->count();

        // Get active offers
        $activeOffers = DB::table('offers')
            ->leftJoin('menu_items', 'offers.target_item_id', '=', 'menu_items.item_id')
            ->where('offers.restaurant_id', $restaurant->restaurant_id)
            ->where('offers.is_active', 1)
            ->where('offers.start_datetime', '<=', DB::raw('GETDATE()'))
            ->where('offers.end_datetime', '>=', DB::raw('GETDATE()'))
            ->select('offers.*', 'menu_items.item_name')
            ->orderBy('offers.created_at', 'desc')
            ->get();

        $itemsWithOffers = $activeOffers->unique('target_item_id')->count();

        return view('restaurant.dashboard', compact(
            'itemCount',
            'availableItems',
            'unavailableItems',
            'activeOffers',
            'itemsWithOffers'
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

        return view('restaurant.add_item', compact('categories'));
    }

    // Store Item
    public function storeItem(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|integer',
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
            'cuisine_id' => 1, // Defaulting for now
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

        // Get items
        $items = DB::table('menu_items')
            ->leftJoin('menu_categories', 'menu_items.category_id', '=', 'menu_categories.category_id')
            ->where('menu_items.restaurant_id', $restaurant->restaurant_id)
            ->select('menu_items.*', 'menu_categories.category_name')
            ->get();

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

        return view('restaurant.add_offer', compact('items'));
    }

    // Store Offer
    public function storeOffer(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer',
            'discount_percentage' => 'required|integer|min:1|max:100',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        // Additional validation for date comparison
        $startDateTime = new DateTime($request->start_date);
        $endDateTime = new DateTime($request->end_date);
        $now = new DateTime();

        if ($endDateTime <= $startDateTime) {
            return redirect()->back()->withErrors(['end_date' => 'End date must be after start date.']);
        }

        if ($startDateTime > $now) {
            return redirect()->back()->withErrors(['start_date' => 'Start date cannot be in the future. Offers must start immediately or in the past.']);
        }

        $ownerId = session('user_id');

        $restaurant = DB::table('restaurants')
            ->where('owner_id', $ownerId)
            ->first();

        if (!$restaurant) {
            return redirect()->route('home')->with('error', 'No restaurant found for your account. Please contact support.');
        }

        // Check if item belongs to this restaurant
        $item = DB::table('menu_items')
            ->where('item_id', $request->item_id)
            ->where('restaurant_id', $restaurant->restaurant_id)
            ->first();

        if (!$item) {
            return redirect()->back()->with('error', 'Invalid item selected.');
        }

        // Format dates for SQL Server - ensure they include seconds and are in correct format
        $startDateTime = new DateTime($request->start_date);
        $endDateTime = new DateTime($request->end_date);
        $startDate = $startDateTime->format('Y-m-d H:i:s');
        $endDate = $endDateTime->format('Y-m-d H:i:s');

        DB::table('offers')->insert([
            'restaurant_id' => $restaurant->restaurant_id,
            'offer_title' => 'Discount on ' . $item->item_name,
            'discount_type' => 'percentage',
            'discount_value' => $request->discount_percentage,
            'target_type' => 'item',
            'target_item_id' => $request->item_id,
            'start_datetime' => $startDate,
            'end_datetime' => $endDate,
            'is_active' => 1,
            'created_at' => DB::raw('GETDATE()'),
        ]);

        return redirect()->route('restaurant.items')
            ->with('success', 'Offer created successfully!');
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