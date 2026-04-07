<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page
     */
    public function showCheckout(Request $request, $restaurantId)
    {
        $customerId = Session::get('user_id');
        if (!$customerId) {
            return redirect()->route('login');
        }

        // Get Cart Items
        $cartItems = DB::select("EXEC sp_view_cart @customer_id = ?, @restaurant_id = ?", [$customerId, $restaurantId]);
        
        if (empty($cartItems)) {
            return redirect()->route('restaurant.details', ['id' => $restaurantId])
                ->with('error', 'Your cart is empty.');
        }

        // Get Addresses
        $addresses = DB::select("EXEC sp_get_customer_addresses @customer_id = ?", [$customerId]);

        // Get Restaurant
        $restaurant = DB::selectOne("EXEC sp_get_restaurant_by_id ?", [$restaurantId]);

        // Calculate Subtotal
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += ($item->unit_price * $item->quantity);
        }

        $delivery = 70.00;
        $discount = 0.00;
        $offerId = $request->query('offer_id');

        // Apply Order-level or Delivery-level Offers
        if ($offerId) {
            $offers = DB::select("EXEC sp_get_active_offers ?", [$restaurantId]);
            // Search for the chosen offer
            $offer = collect($offers)->firstWhere('offer_id', $offerId);
            
            if ($offer) {
                if ($offer->discount_type === 'free_delivery') {
                    $delivery = 0.00;
                } elseif ($offer->target_type === 'restaurant') {
                    if ($offer->discount_type === 'flat') {
                        $discount = (float) $offer->discount_value;
                    } elseif ($offer->discount_type === 'percentage') {
                        $discount = $subtotal * ((float) $offer->discount_value / 100);
                    }
                }
            }
        }
        
        $total = max(0, $subtotal - $discount) + $delivery;

        return view('checkout', compact(
            'cartItems', 'addresses', 'restaurantId', 'restaurant', 
            'subtotal', 'discount', 'delivery', 'total', 'offerId'
        ));
    }

    /**
     * Place the Order
     */
    public function placeOrder(Request $request, $restaurantId)
    {
        $customerId = Session::get('user_id');
        if (!$customerId) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'address_id' => 'required|integer',
            'payment_method' => 'required|string|in:cash,card,bkash,nagad,credit',
            'delivery' => 'required|numeric',
            'discount' => 'required|numeric',
            'offer_id' => 'nullable|integer'
        ]);

        try {
            $result = DB::selectOne(
                "EXEC sp_place_order @customer_id = ?, @restaurant_id = ?, @delivery_address_id = ?, @payment_method = ?, @delivery_fee = ?, @discount_amount = ?, @offer_id = ?",
                [
                    $customerId,
                    $restaurantId,
                    $validated['address_id'],
                    $validated['payment_method'],
                    $validated['delivery'],
                    $validated['discount'],
                    $validated['offer_id'] ?? null
                ]
            );

            return redirect()->route('home')->with('success', 'Order placed successfully! Order ID: ' . ($result->order_id ?? ''));

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }
}
