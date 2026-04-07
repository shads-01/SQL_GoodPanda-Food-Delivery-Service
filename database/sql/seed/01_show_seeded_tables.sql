USE goodpanda_db;
GO

-- 1. List all existing tables to verify schema
SELECT name AS Table_Name 
FROM sys.tables 
ORDER BY name;
GO

-- 2. View data from Core Identity & Location tables
SELECT * FROM users;
SELECT * FROM customer_addresses;
GO

-- 3. View data from Restaurant & Menu structure
SELECT * FROM restaurants;
SELECT * FROM cuisine_types;
SELECT * FROM restaurant_cuisines;
SELECT * FROM restaurant_ratings;
SELECT * FROM menu_categories;
SELECT * FROM menu_items;
GO

-- 4. View data from the Offer & Promotion system
SELECT * FROM offers;
GO

-- 5. View data from the Order & Cart workflow
SELECT * FROM cart;
SELECT * FROM cart_items;
SELECT * FROM orders;
GO

-- 6. View data from Fulfillment (Payments, Delivery, Reviews)
SELECT * FROM payments;
SELECT * FROM delivery_partner_profiles;
SELECT * FROM deliveries;
SELECT * FROM reviews;
GO

-- 7. View data from Laravel Internals
SELECT * FROM cache;
SELECT * FROM cache_locks;
SELECT * FROM jobs;
SELECT * FROM job_batches;
SELECT * FROM failed_jobs;
GO
