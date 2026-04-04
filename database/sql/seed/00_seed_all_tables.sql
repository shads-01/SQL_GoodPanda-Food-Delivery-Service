USE goodpanda_db;
GO

-- 1. SEED USERS (Customers, Owners, Delivery Partners)
-- Passwords are dummy strings (in a real app, these would be Bcrypt hashes)
-- Use password: customer123 for login
INSERT INTO users (role, name, email, phone_number, password, is_active, created_at)
VALUES 
('customer', 'Shahadat Hasan', 'shahadat@example.com', '01711000001', '$2y$12$imBxiNOY7V1a1gqnO3SZCu.ousibNa1HhQSLp4BWHVEwBCoMKZyPS', 1, GETDATE()),
('restaurant_owner', 'Lab Instructor', 'instructor@aust.edu', '01711000002', '$2y$12$imBxiNOY7V1a1gqnO3SZCu.ousibNa1HhQSLp4BWHVEwBCoMKZyPS', 1, GETDATE()),
('customer', 'John Doe', 'john@example.com', '01811000003', '$2y$12$imBxiNOY7V1a1gqnO3SZCu.ousibNa1HhQSLp4BWHVEwBCoMKZyPS', 1, GETDATE()),
('restaurant_owner', 'Jane Smith', 'jane@example.com', '01911000004', '$2y$12$imBxiNOY7V1a1gqnO3SZCu.ousibNa1HhQSLp4BWHVEwBCoMKZyPS', 1, GETDATE()),
('delivery_partner', 'Rahim Delivery', 'rahim@example.com', '01511999991', '$2y$12$imBxiNOY7V1a1gqnO3SZCu.ousibNa1HhQSLp4BWHVEwBCoMKZyPS', 1, GETDATE()),
('delivery_partner', 'Karim Logistics', 'karim@example.com', '01511999992', '$2y$12$imBxiNOY7V1a1gqnO3SZCu.ousibNa1HhQSLp4BWHVEwBCoMKZyPS', 1, GETDATE());

-- 2. SEED PROFILES
-- Customer Profiles
INSERT INTO customer_profiles (customer_id, created_at)
VALUES (1, GETDATE()), (3, GETDATE());

-- Restaurant Owner Profiles
INSERT INTO restaurant_owner_profiles (owner_id, created_at)
VALUES (2, GETDATE()), (4, GETDATE());

-- Delivery Partner Profiles
INSERT INTO delivery_partner_profiles (partner_id, vehicle_type, is_available, avg_rating, created_at)
VALUES 
(5, 'bike', 1, 4.80, GETDATE()),
(6, 'scooter', 1, 4.50, GETDATE());

-- 3. SEED CUSTOMER ADDRESSES
INSERT INTO customer_addresses (customer_id, label, address_line, city, is_default)
VALUES 
(1, 'Home', '123 Tejgaon Industrial Area', 'Dhaka', 1),
(1, 'AUST University', '141-142 Love Road', 'Dhaka', 0),
(3, 'Office', 'Gulshan 2, Road 45', 'Dhaka', 1);

-- 4. SEED CUISINE TYPES
INSERT INTO cuisine_types (cuisine_name, description, cuisine_image)
VALUES 
('Bengali', 'Traditional local dishes', 'bg_cuisine.jpg'),
('Chinese', 'Cantonese and Szechuan style', 'zh_cuisine.jpg'),
('Italian', 'Pizza, Pasta, and more', 'it_cuisine.jpg'),
('Fast Food', 'Burgers, Fries, and Quick Bites', 'ff_cuisine.jpg');

-- 5. SEED RESTAURANTS
INSERT INTO restaurants (owner_id, name, location, phone_number, profile_image, cover_image, open_status, created_at)
VALUES 
(2, 'Panda Express', 'Banani, Dhaka', '01711000010', 'panda_logo.png', 'panda_cover.jpg', 1, GETDATE()),
(2, 'Pizza Hut', 'Dhanmondi, Dhaka', '01711000011', 'pizza_hut.png', 'pizza_cover.jpg', 1, GETDATE()),
(4, 'Burger King', 'Uttara, Dhaka', '01711000012', 'bk_logo.png', 'bk_cover.jpg', 1, GETDATE());

-- 6. SEED RESTAURANT CUISINES (M:N)
INSERT INTO restaurant_cuisines (restaurant_id, cuisine_id)
VALUES 
(1, 2), -- Panda Express: Chinese
(2, 3), -- Pizza Hut: Italian
(3, 4); -- Burger King: Fast Food

-- 7. SEED RESTAURANT RATINGS
INSERT INTO restaurant_ratings (restaurant_id, avg_rating, total_reviews)
VALUES 
(1, 4.50, 1),
(2, 4.00, 1),
(3, 0.00, 0);

-- 8. SEED MENU CATEGORIES
INSERT INTO menu_categories (restaurant_id, category_name, display_order)
VALUES 
(1, 'Main Course', 1),
(1, 'Appetizers', 2),
(2, 'Classic Pizzas', 1),
(3, 'Whoppers', 1);

-- 9. SEED MENU ITEMS
INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
VALUES 
(1, 1, 2, 'Kung Pao Chicken', 'Spicy stir-fried chicken', 'chicken.jpg', 450.00, 1, GETDATE()),
(1, 2, 2, 'Spring Rolls', 'Vegetable filled rolls', 'rolls.jpg', 120.00, 1, GETDATE()),
(2, 3, 3, 'Margherita Pizza', 'Cheese and Tomato', 'pizza.jpg', 850.00, 1, GETDATE()),
(3, 4, 4, 'Whopper Junior', 'Flame-grilled beef', 'burger.jpg', 290.00, 1, GETDATE());

-- 10. SEED OFFERS
INSERT INTO offers (restaurant_id, offer_title, discount_type, discount_value, target_type, start_datetime, end_datetime, is_active, created_at)
VALUES 
(1, '20% Off Main Course', 'percentage', 20.00, 'category', '2026-03-01', '2026-12-31', 1, GETDATE()),
(2, 'Free Delivery Weekend', 'free_delivery', NULL, 'restaurant', '2026-03-31', '2026-04-02', 1, GETDATE());

-- 11. SEED CART & CART ITEMS
-- Customer 1 has a cart at Restaurant 1
INSERT INTO cart (customer_id, restaurant_id, status) VALUES (1, 1, 'active');
INSERT INTO cart_items (cart_id, item_id, quantity, unit_price) VALUES (1, 1, 2, 450.00);

-- 12. SEED ORDERS & PAYMENTS (Items are linked via cart_id)
INSERT INTO orders (customer_id, restaurant_id, cart_id, delivery_address_id, order_status, subtotal, discount_amount, delivery_fee, total_amount)
VALUES (1, 1, 1, 1, 'delivered', 900.00, 0.00, 50.00, 950.00);

INSERT INTO payments (order_id, customer_id, payment_method, payment_status, amount_paid, transaction_ref)
VALUES (1, 1, 'bkash', 'paid', 950.00, 'TRX-100200300');

-- 13. SEED DELIVERIES
INSERT INTO deliveries (order_id, partner_id, delivery_address_id, delivery_status, delivered_time)
VALUES (1, 5, 1, 'delivered', GETDATE());

-- 14. SEED REVIEWS
INSERT INTO reviews (order_id, customer_id, restaurant_id, partner_id, restaurant_rating, delivery_rating, comment, review_datetime)
VALUES (1, 1, 1, 5, 5, 5, 'The Kung Pao Chicken was excellent!', GETDATE());
