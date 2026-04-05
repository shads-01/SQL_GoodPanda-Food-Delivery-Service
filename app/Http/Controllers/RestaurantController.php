<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    // Add Item Page
    public function addItem()
    {
        $ownerId = session('user_id');

        $restaurant = DB::table('restaurants')
            ->where('owner_id', $ownerId)
            ->first();

        if (!$restaurant) {
            return redirect()->route('owner.dashboard')->with('error', 'No restaurant found for your account. Please contact support.');
        }

        $categories = DB::table('menu_categories')
            ->where('restaurant_id', $restaurant->restaurant_id)
            ->get();

        return view('restaurant.add_item', compact('categories'));
    }

    // Store Item
    public function storeItem(Request $request)
    {
        $ownerId = session('user_id');

        $restaurant = DB::table('restaurants')
            ->where('owner_id', $ownerId)
            ->first();

        if (!$restaurant) {
            return redirect()->route('owner.dashboard')->with('error', 'No restaurant found for your account. Please contact support.');
        }

        DB::table('menu_items')->insert([
            'restaurant_id' => $restaurant->restaurant_id,
            'category_id'   => $request->category_id,
            'cuisine_id'    => 1,
            'item_name'     => $request->name,
            'description'   => $request->description,
            'item_image'    => 'default.jpg',
            'price'         => $request->price,
            'is_available'  => 1,
            'created_at'    => now(),
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
            return redirect()->route('owner.dashboard')->with('error', 'No restaurant found for your account. Please contact support.');
        }

        $items = DB::table('menu_items')
            ->leftJoin('menu_categories', 'menu_items.category_id', '=', 'menu_categories.category_id')
            ->where('menu_items.restaurant_id', $restaurant->restaurant_id)
            ->select('menu_items.*', 'menu_categories.category_name')
            ->get();

        return view('restaurant.items', compact('items'));
    }
}