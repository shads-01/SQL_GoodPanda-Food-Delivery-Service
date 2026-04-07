<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate based on your SQL schema constraints
        $validated = $request->validate([
            'order_id' => 'required|integer|exists:orders,order_id',
            'restaurant_id' => 'required|integer|exists:restaurants,restaurant_id',
            'partner_id' => 'nullable|integer|exists:delivery_partner_profiles,partner_id',
            'restaurant_rating' => 'required|integer|min:1|max:5',
            'delivery_rating' => 'nullable|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // 2. Ensure an order is only reviewed once (due to UNIQUE constraint on order_id)
        $existingReview = DB::table('reviews')
            ->where('order_id', $validated['order_id'])
            ->exists();

        if ($existingReview) {
            return back()->withErrors(['error' => 'You have already reviewed this order.']);
        }

        // 3. Insert into the database using raw SQL file
        $sql = file_get_contents(database_path('sql/queries/customer/insert_review.sql'));
        DB::statement($sql, [
            $validated['order_id'],
            session('user_id'),
            $validated['restaurant_id'],
            $validated['partner_id'] ?: null,
            $validated['restaurant_rating'],
            $validated['delivery_rating'] ?: null,
            $validated['comment']
        ]);

        // 4. Redirect back with success message
        return redirect()->route('customer.order_history')->with('success', 'Thank you! Your review has been submitted.');
    }
}