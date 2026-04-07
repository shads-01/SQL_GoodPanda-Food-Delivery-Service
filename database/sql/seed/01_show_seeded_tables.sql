USE goodpanda_db;
GO

-- 1. List all existing tables to verify schema
SELECT name AS Table_Name 
FROM sys.tables 
ORDER BY name;
GO

-- 2. Core Identity & Location
SELECT * FROM users;
SELECT * FROM customer_profiles;
SELECT * FROM restaurant_owner_profiles;
SELECT * FROM delivery_partner_profiles;
SELECT * FROM customer_addresses;
GO

-- 3. Restaurant & Menu Structure
SELECT * FROM restaurants;
SELECT * FROM cuisine_types;
SELECT * FROM restaurant_cuisines;
SELECT * FROM restaurant_ratings;
SELECT * FROM menu_categories;
SELECT * FROM menu_items;
GO

-- 4. Offers & Promotions
SELECT * FROM offers;
GO

-- 5. Order & Cart Workflow
SELECT * FROM cart;
SELECT * FROM cart_items;
SELECT * FROM orders;
-- Note: 'order_details' was not in your primary schema, orders are tracked via orders/cart_items.
GO

-- 6. Fulfillment (Payments, Delivery, Reviews)
SELECT * FROM payments;
SELECT * FROM deliveries;
SELECT * FROM reviews;
GO

-- 7. Laravel Internals
SELECT * FROM cache;
SELECT * FROM cache_locks;
SELECT * FROM jobs;
SELECT * FROM job_batches;
SELECT * FROM failed_jobs;
GO