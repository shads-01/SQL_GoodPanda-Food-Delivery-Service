USE goodpanda_db;
GO
-- 1. Drop tables with foreign keys first (Child tables)
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS deliveries;
DROP TABLE IF EXISTS payments;
DROP TABLE IF EXISTS order_details; -- Note: This table wasn't in your CREATE script but was in your DROP
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS cart_items;
DROP TABLE IF EXISTS cart;
DROP TABLE IF EXISTS offers;
DROP TABLE IF EXISTS menu_items;
DROP TABLE IF EXISTS menu_categories;
DROP TABLE IF EXISTS restaurant_ratings;
DROP TABLE IF EXISTS restaurant_cuisines;
DROP TABLE IF EXISTS restaurants;
DROP TABLE IF EXISTS cuisine_types;
DROP TABLE IF EXISTS customer_addresses;

-- 2. Drop the specific profile tables
DROP TABLE IF EXISTS delivery_partner_profiles;
DROP TABLE IF EXISTS restaurant_owner_profiles;
DROP TABLE IF EXISTS customer_profiles;

-- 3. Drop the base users and Laravel internal tables
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS failed_jobs;
DROP TABLE IF EXISTS job_batches;
DROP TABLE IF EXISTS jobs;
DROP TABLE IF EXISTS cache_locks;
DROP TABLE IF EXISTS cache;
GO