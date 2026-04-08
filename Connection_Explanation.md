# GoodPanda - Architecture & Data Flow Connection Explanation

This document details how the diverse SQL scripts map to the Controllers, how each main feature functions beneath the hood, and where it connects to the Blade frontend in the application.

## 1. Authentication & Registration
**Feature Logic:**
The system authenticates against a unified `users` table but branches registrations based on user roles (`customer`, `restaurant_owner`, `delivery_partner`). File uploads (Cloudinary for restaurant covers) and complex relational inserts (default addresses or business categories) are executed sequentially in transactions.
**Frontend Call:**
- Handled internally by login/registration flows.
**Controller Execution & SQL:**
- `AuthController@login` -> Calls `database/sql/queries/auth/find_user_by_email.sql` via `DB::select()`.
- `AuthController@register` -> Coordinates the setup using several scripts linearly:
  - `insert_user.sql`
  - `insert_owner_profile.sql` / `insert_restaurant.sql` / `insert_category.sql`
  - `insert_delivery_profile.sql`
  - `insert_customer_profile.sql` / `insert_address.sql`

## 2. Customer Dashboard, Search & Discovery
**Feature Logic:**
Allows the customer to seamlessly explore top restaurants, active offers, and discover menu items. Search features AJAX-powered autocomplete and advanced filter criteria (cuisine, sorting).
**Frontend Call:**
- `resources/views/home.blade.php`
- `resources/views/customer/search.blade.php`
- The top universal search bar via JS calling the endpoints internally.
**Controller Execution & SQL:**
- `CustomerController@home`: Runs native queries using `aggregate_top_restaurants.sql` and `get_top_offers.sql`.
- `CustomerController@searchSuggestions`: Uses inline raw SQL strings for rapid UI autocomplete data fetching.
- `CustomerController@search` and `@offers`: Uses Laravel Query Builder (`DB::table(...)`) with complex array mappings to dynamically enforce price adjustments and filter conditions, bypassing static SQL scripts. 

## 3. Customer Profile & Addresses
**Feature Logic:**
Features dedicated to displaying current basic details, historical orders, and saving dynamic delivery addresses. "Soft deleting" an account obfuscates data.
**Frontend Call:**
- `resources/views/customer/profile.blade.php`
- `resources/views/customer/order_history.blade.php`
**Controller Execution & SQL:**
- `CustomerController@profile`: Inlines simple `DB::table` lookups.
- `updateProfile`, `deleteAddress`, `updateAddress`, `storeAddress`: Rely heavily on explicit `.sql` files:
  - `update_profile.sql`
  - `update_address.sql`
  - `delete_address.sql`
- Note: Account deletion executes an inline soft-delete `DB::statement` query.

## 4. Shopping Cart Actions
**Feature Logic:**
Handles managing an active cart dynamically. It securely associates the cart instance with the user and enforces atomic operations without exposing raw tables to frontend.
**Frontend Call:**
- AJAX fetch routines embedded typically in JS within `restaurant_detail.blade.php` and general navigations.
**Controller Execution & SQL:**
- `CartController`: Exclusively proxies to comprehensive Stored Procedures to offload validation logic.
  - `EXEC sp_view_cart`
  - `EXEC sp_add_to_cart`
  - `EXEC sp_update_cart_quantity`
  - `EXEC sp_remove_from_cart`

## 5. Checkout & Order Processing
**Feature Logic:**
Retrieves user location preferences, applies promotional discounts or free deliveries natively, recalculates cart totals dynamically, and finally registers a formal `orders` record.
**Frontend Call:**
- Executed on final processing via `resources/views/checkout.blade.php`
**Controller Execution & SQL:**
- `CheckoutController@showCheckout`: Resolves sub-levels via procedures:
  - `sp_get_customer_addresses`
  - `sp_get_restaurant_by_id`
  - `sp_get_active_offers`
- `CheckoutController@placeOrder`: Offloads complex multi-table inserts using:
  - `EXEC sp_place_order`

## 6. Restaurant Owner Management
**Feature Logic:**
Back-office functionality allowing owners to curate menus, update pricing, define offers, and track active statuses dynamically.
**Frontend Call:**
- Bound intricately to `resources/views/restaurant/*` blades.
**Controller Execution & SQL:**
- `RestaurantController` methods like `dashboard`, `addItem`, `editItem` rely entirely on Laravel's Query Builder functions mirroring typical ORM actions.
- Listing items invokes `sp_get_items_by_res_id.sql`.
- Adding an offer runs raw parameters against `insert_offer.sql`.
