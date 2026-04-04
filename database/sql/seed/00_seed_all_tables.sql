USE goodpanda_db;
GO

-- 1. SEED USERS (Customers, Owners, Delivery Partners)
-- Passwords: customer123 / instructor123 / etc.
INSERT INTO users (role, name, email, phone_number, password, is_active, created_at)
VALUES 
('customer', 'Shahadat Hasan', 'shahadat@example.com', '01711000001', '$2y$12$imBxiNOY7V1a1gqnO3SZCu.ousibNa1HhQSLp4BWHVEwBCoMKZyPS', 1, GETDATE()),
('restaurant_owner', 'Lab Instructor', 'instructor@aust.edu', '01711000002', '$2y$12$imBxiNOY7V1a1gqnO3SZCu.ousibNa1HhQSLp4BWHVEwBCoMKZyPS', 1, GETDATE()),
('customer', 'John Doe', 'john@example.com', '01811000003', '$2y$12$imBxiNOY7V1a1gqnO3SZCu.ousibNa1HhQSLp4BWHVEwBCoMKZyPS', 1, GETDATE()),
('restaurant_owner', 'Jane Smith', 'jane@example.com', '01911000004', '$2y$12$imBxiNOY7V1a1gqnO3SZCu.ousibNa1HhQSLp4BWHVEwBCoMKZyPS', 1, GETDATE()),
('delivery_partner', 'Rahim Delivery', 'rahim@example.com', '01511999991', '$2y$12$imBxiNOY7V1a1gqnO3SZCu.ousibNa1HhQSLp4BWHVEwBCoMKZyPS', 1, GETDATE()),
('delivery_partner', 'Karim Logistics', 'karim@example.com', '01511999992', '$2y$12$imBxiNOY7V1a1gqnO3SZCu.ousibNa1HhQSLp4BWHVEwBCoMKZyPS', 1, GETDATE());

-- 2. SEED PROFILES (Using subqueries to get correct IDs)
-- Customer Profiles
INSERT INTO customer_profiles (customer_id, created_at)
SELECT id, GETDATE() FROM users WHERE email IN ('shahadat@example.com', 'john@example.com');

-- Restaurant Owner Profiles
INSERT INTO restaurant_owner_profiles (owner_id, created_at)
SELECT id, GETDATE() FROM users WHERE email IN ('instructor@aust.edu', 'jane@example.com');

-- Delivery Partner Profiles
INSERT INTO delivery_partner_profiles (partner_id, vehicle_type, is_available, avg_rating, created_at)
SELECT id, 'bike', 1, 4.80, GETDATE() FROM users WHERE email = 'rahim@example.com';
INSERT INTO delivery_partner_profiles (partner_id, vehicle_type, is_available, avg_rating, created_at)
SELECT id, 'scooter', 1, 4.50, GETDATE() FROM users WHERE email = 'karim@example.com';

-- 3. SEED CUSTOMER ADDRESSES
INSERT INTO customer_addresses (customer_id, label, address_line, city, is_default)
SELECT id, 'Home', '123 Tejgaon Industrial Area', 'Dhaka', 1 FROM users WHERE email = 'shahadat@example.com';
INSERT INTO customer_addresses (customer_id, label, address_line, city, is_default)
SELECT id, 'AUST University', '141-142 Love Road', 'Dhaka', 0 FROM users WHERE email = 'shahadat@example.com';
INSERT INTO customer_addresses (customer_id, label, address_line, city, is_default)
SELECT id, 'Office', 'Gulshan 2, Road 45', 'Dhaka', 1 FROM users WHERE email = 'john@example.com';

-- 4. SEED CUISINE TYPES
INSERT INTO cuisine_types (cuisine_name, description, cuisine_image)
VALUES 
('Bengali', 'Traditional local dishes', 'bg_cuisine.jpg'),
('Chinese', 'Cantonese and Szechuan style', 'zh_cuisine.jpg'),
('Italian', 'Pizza, Pasta, and more', 'it_cuisine.jpg'),
('Fast Food', 'Burgers, Fries, and Quick Bites', 'ff_cuisine.jpg');

-- 5. SEED RESTAURANTS (One owner per restaurant)
INSERT INTO restaurants (owner_id, name, location, phone_number, profile_image, cover_image, open_status, created_at)
SELECT id, 'Panda Express', 'Banani, Dhaka', '01711000010', 'panda_logo.png', 'panda_cover.jpg', 1, GETDATE() FROM users WHERE email = 'instructor@aust.edu';
INSERT INTO restaurants (owner_id, name, location, phone_number, profile_image, cover_image, open_status, created_at)
SELECT id, 'Burger King', 'Uttara, Dhaka', '01711000012', 'bk_logo.png', 'bk_cover.jpg', 1, GETDATE() FROM users WHERE email = 'jane@example.com';

-- 6. SEED RESTAURANT CUISINES (M:N)
INSERT INTO restaurant_cuisines (restaurant_id, cuisine_id)
SELECT r.restaurant_id, c.cuisine_id 
FROM restaurants r, cuisine_types c 
WHERE r.name = 'Panda Express' AND c.cuisine_name = 'Chinese';

INSERT INTO restaurant_cuisines (restaurant_id, cuisine_id)
SELECT r.restaurant_id, c.cuisine_id 
FROM restaurants r, cuisine_types c 
WHERE r.name = 'Burger King' AND c.cuisine_name = 'Fast Food';

-- 7. SEED RESTAURANT RATINGS
INSERT INTO restaurant_ratings (restaurant_id, avg_rating, total_reviews)
SELECT restaurant_id, 4.50, 1 FROM restaurants WHERE name = 'Panda Express';
INSERT INTO restaurant_ratings (restaurant_id, avg_rating, total_reviews)
SELECT restaurant_id, 0.00, 0 FROM restaurants WHERE name = 'Burger King';

-- 8. SEED MENU CATEGORIES
INSERT INTO menu_categories (restaurant_id, category_name, display_order)
SELECT restaurant_id, 'Main Course', 1 FROM restaurants WHERE name = 'Panda Express';
INSERT INTO menu_categories (restaurant_id, category_name, display_order)
SELECT restaurant_id, 'Whoppers', 1 FROM restaurants WHERE name = 'Burger King';

-- 9. SEED MENU ITEMS
INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
SELECT r.restaurant_id, mc.category_id, ct.cuisine_id, 'Kung Pao Chicken', 'Spicy chicken', 'chicken.jpg', 450.00, 1, GETDATE()
FROM restaurants r, menu_categories mc, cuisine_types ct
WHERE r.name = 'Panda Express' AND mc.category_name = 'Main Course' AND ct.cuisine_name = 'Chinese';

INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
SELECT r.restaurant_id, mc.category_id, ct.cuisine_id, 'Whopper Junior', 'Flame-grilled beef', 'burger.jpg', 290.00, 1, GETDATE()
FROM restaurants r, menu_categories mc, cuisine_types ct
WHERE r.name = 'Burger King' AND mc.category_name = 'Whoppers' AND ct.cuisine_name = 'Fast Food';

-- 10. SEED OFFERS
INSERT INTO offers (restaurant_id, offer_title, discount_type, discount_value, target_type, start_datetime, end_datetime, is_active, created_at)
SELECT restaurant_id, '20% Off Main Course', 'percentage', 20.00, 'category', '2026-03-01', '2026-12-31', 1, GETDATE()
FROM restaurants WHERE name = 'Panda Express';

-- 11. SEED CART
INSERT INTO cart (customer_id, restaurant_id, status)
SELECT u.id, r.restaurant_id, 'active'
FROM users u, restaurants r
WHERE u.email = 'shahadat@example.com' AND r.name = 'Panda Express';

-- 12. SEED CART ITEMS
INSERT INTO cart_items (cart_id, item_id, quantity, unit_price)
SELECT c.cart_id, mi.item_id, 2, mi.price
FROM cart c, menu_items mi
WHERE c.customer_id = (SELECT id FROM users WHERE email = 'shahadat@example.com') AND mi.item_name = 'Kung Pao Chicken';

-- 13. SEED ORDERS
INSERT INTO orders (customer_id, restaurant_id, cart_id, delivery_address_id, order_status, subtotal, discount_amount, delivery_fee, total_amount)
SELECT u.id, r.restaurant_id, c.cart_id, ca.address_id, 'delivered', 900.00, 0.00, 50.00, 950.00
FROM users u, restaurants r, cart c, customer_addresses ca
WHERE u.email = 'shahadat@example.com' AND r.name = 'Panda Express' AND c.customer_id = u.id AND ca.label = 'Home' AND ca.customer_id = u.id;

-- 14. SEED PAYMENTS
INSERT INTO payments (order_id, customer_id, payment_method, payment_status, amount_paid, transaction_ref)
SELECT o.order_id, u.id, 'bkash', 'paid', 950.00, 'TRX-100200300'
FROM orders o, users u
WHERE u.email = 'shahadat@example.com' AND o.customer_id = u.id;

-- 15. SEED DELIVERIES
INSERT INTO deliveries (order_id, partner_id, delivery_address_id, delivery_status, delivered_time)
SELECT o.order_id, d.partner_id, ca.address_id, 'delivered', GETDATE()
FROM orders o, delivery_partner_profiles d, customer_addresses ca, users up
WHERE up.email = 'rahim@example.com' AND d.partner_id = up.id AND o.customer_id = (SELECT id FROM users WHERE email = 'shahadat@example.com') AND ca.label = 'Home';

-- 16. SEED REVIEWS
INSERT INTO reviews (order_id, customer_id, restaurant_id, partner_id, restaurant_rating, delivery_rating, comment, review_datetime)
SELECT o.order_id, o.customer_id, o.restaurant_id, d.partner_id, 5, 5, 'Great!', GETDATE()
FROM orders o, delivery_partner_profiles d, users up
WHERE up.email = 'rahim@example.com' AND d.partner_id = up.id AND o.customer_id = (SELECT id FROM users WHERE email = 'shahadat@example.com');

GO
