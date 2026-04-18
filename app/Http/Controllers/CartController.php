<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Get the active cart for the logged in customer and specific restaurant.
     */
    public function getCart(Request $request, $restaurantId)
    {
        $customerId = Session::get('user_id');
        if (!$customerId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        try {
            $cartItems = DB::select("EXEC sp_view_cart @customer_id = ?, @restaurant_id = ?", [$customerId, $restaurantId]);
            return response()->json(['success' => true, 'cart' => $cartItems]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Add an item to the cart or update quantity if it exists.
     */
    public function addToCart(Request $request)
    {
        $customerId = Session::get('user_id');
        if (!$customerId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'restaurant_id' => 'required|integer',
            'item_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric'
        ]);

        try {
            DB::statement(
                "EXEC sp_add_to_cart @customer_id = ?, @restaurant_id = ?, @item_id = ?, @quantity = ?, @unit_price = ?",
                [
                    $customerId,
                    $validated['restaurant_id'],
                    $validated['item_id'],
                    $validated['quantity'],
                    $validated['unit_price']
                ]
            );

            return response()->json(['success' => true, 'message' => 'Item added to cart']);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Cart Add Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the quantity of an item in the cart.
     */
    public function updateQuantity(Request $request)
    {
        $customerId = Session::get('user_id');
        if (!$customerId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $validated = $request->all();
        // Fallback for form data since qty_change can be positive or negative
        $restaurantId = $validated['restaurant_id'] ?? null;
        $itemId = $validated['item_id'] ?? null;
        $qtyChange = $validated['qty_change'] ?? null;

        if (!$restaurantId || !$itemId || !$qtyChange) {
             return response()->json(['success' => false, 'message' => 'Missing parameters'], 400);
        }

        try {
            DB::statement(
                "EXEC sp_update_cart_quantity @customer_id = ?, @restaurant_id = ?, @item_id = ?, @qty_change = ?",
                [
                    $customerId,
                    $restaurantId,
                    $itemId,
                    $qtyChange
                ]
            );

            return response()->json(['success' => true, 'message' => 'Cart quantity updated']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Completely remove an item from the cart.
     */
    public function removeItem(Request $request)
    {
        $customerId = Session::get('user_id');
        if (!$customerId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'restaurant_id' => 'required|integer',
            'item_id'       => 'required|integer'
        ]);

        try {
            DB::statement(
                "EXEC sp_remove_from_cart @customer_id = ?, @restaurant_id = ?, @item_id = ?",
                [$customerId, $validated['restaurant_id'], $validated['item_id']]
            );

            return response()->json(['success' => true, 'message' => 'Item removed from cart']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Clear the cart (mark as abandoned)
     */
    public function clearCart(Request $request)
    {
        $customerId = Session::get('user_id');
        if (!$customerId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'restaurant_id' => 'required|integer'
        ]);

        try {
            // Delete cart items first (FK constraint), then the cart row
            DB::statement(
                "DELETE ci FROM cart_items ci INNER JOIN cart c ON ci.cart_id = c.cart_id WHERE c.customer_id = ? AND c.restaurant_id = ? AND c.status = 'active'",
                [$customerId, $validated['restaurant_id']]
            );
            DB::statement(
                "DELETE FROM cart WHERE customer_id = ? AND restaurant_id = ? AND status = 'active'",
                [$customerId, $validated['restaurant_id']]
            );

            return response()->json(['success' => true, 'message' => 'Cart cleared']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get the customer's active cart across all restaurants (for the global navbar cart).
     * Returns items along with the restaurant_id so the navbar knows where to checkout.
     */
    public function getActiveCart()
    {
        $customerId = Session::get('user_id');
        if (!$customerId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        try {
            $cartItems = DB::select(
                file_get_contents(database_path('sql/queries/customer/get_active_cart.sql')),
                [$customerId]
            );
            $restaurantId = !empty($cartItems) ? $cartItems[0]->restaurant_id : null;
            return response()->json(['success' => true, 'cart' => $cartItems, 'restaurant_id' => $restaurantId]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get active offers for a given restaurant (for the global navbar cart discount logic).
     */
    public function getOffersForRestaurant($restaurantId)
    {
        try {
            $offers = DB::select("EXEC sp_get_active_offers ?", [$restaurantId]);
            return response()->json(['success' => true, 'offers' => $offers]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
