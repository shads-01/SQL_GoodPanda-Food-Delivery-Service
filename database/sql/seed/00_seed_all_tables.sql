USE goodpanda_db;
GO

-- 1. SEED USERS (Customers, Owners, Admins)
-- Passwords are dummy strings (in a real app, these would be Bcrypt hashes)
-- Use password: customer123 for login
INSERT INTO users (name, email, phone_number, password, is_active, created_at)
VALUES 
('Shahadat Hasan', 'shahadat@example.com', '01711000001', '$2y$12$imBxiNOY7V1a1gqnO3SZCu.ousibNa1HhQSLp4BWHVEwBCoMKZyPS', 1, GETDATE()),
('Lab Instructor', 'instructor@aust.edu', '01711000002', '$2y$12$imBxiNOY7V1a1gqnO3SZCu.ousibNa1HhQSLp4BWHVEwBCoMKZyPS', 1, GETDATE()),
('John Doe', 'john@example.com', '01811000003', '$2y$12$imBxiNOY7V1a1gqnO3SZCu.ousibNa1HhQSLp4BWHVEwBCoMKZyPS', 1, GETDATE()),
('Jane Smith', 'jane@example.com', '01911000004', '$2y$12$imBxiNOY7V1a1gqnO3SZCu.ousibNa1HhQSLp4BWHVEwBCoMKZyPS', 1, GETDATE());


-- 2. SEED CUSTOMER ADDRESSES
INSERT INTO customer_addresses (customer_id, label, address_line, city, is_default)
VALUES 
(1, 'Home', '123 Tejgaon Industrial Area', 'Dhaka', 1),
(1, 'AUST University', '141-142 Love Road', 'Dhaka', 0),
(3, 'Office', 'Gulshan 2, Road 45', 'Dhaka', 1);

-- 3. SEED CUISINE TYPES
INSERT INTO cuisine_types (cuisine_name, description)
VALUES 
('Bengali', 'Traditional local dishes'),
('Chinese', 'Cantonese and Szechuan style'),
('Italian', 'Pizza, Pasta, and more'),
('Fast Food', 'Burgers, Fries, and Quick Bites');

-- 4. SEED RESTAURANTS
INSERT INTO restaurants (owner_id, name, location, phone_number, profile_image, open_status, created_at)
VALUES 
(2, 'Panda Express', 'Banani, Dhaka', '029881122', 'panda_logo.png', 1, GETDATE()),
(2, 'Pizza Hut', 'Dhanmondi, Dhaka', '028883344', 'pizza_hut.png', 1, GETDATE()),
(4, 'Burger King', 'Uttara, Dhaka', '027775566', 'bk_logo.png', 1, GETDATE());

-- 5. SEED RESTAURANT CUISINES (M:N)
INSERT INTO restaurant_cuisines (restaurant_id, cuisine_id)
VALUES 
(1, 2), -- Panda Express: Chinese
(2, 3), -- Pizza Hut: Italian
(3, 4); -- Burger King: Fast Food

-- 6. SEED RESTAURANT RATINGS
INSERT INTO restaurant_ratings (restaurant_id, avg_rating, total_reviews, last_updated)
VALUES 
(1, 4.50, 1, GETDATE()),
(2, 4.00, 1, GETDATE()),
(3, 0.00, 0, GETDATE());

-- 7. SEED MENU CATEGORIES
INSERT INTO menu_categories (restaurant_id, category_name, display_order)
VALUES 
(1, 'Main Course', 1),
(1, 'Appetizers', 2),
(2, 'Classic Pizzas', 1),
(3, 'Whoppers', 1);

-- 8. SEED MENU ITEMS
INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available)
VALUES 
(1, 1, 2, 'Kung Pao Chicken', 'Spicy stir-fried chicken', 'chicken.jpg', 450.00, 1),
(1, 2, 2, 'Spring Rolls', 'Vegetable filled rolls', 'rolls.jpg', 120.00, 1),
(2, 3, 3, 'Margherita Pizza', 'Cheese and Tomato', 'pizza.jpg', 850.00, 1),
(3, 4, 4, 'Whopper Junior', 'Flame-grilled beef', 'burger.jpg', 290.00, 1);

-- 9. SEED OFFERS
INSERT INTO offers (restaurant_id, offer_title, discount_type, discount_value, target_type, start_datetime, end_datetime, is_active)
VALUES 
(1, '20% Off Main Course', 'percentage', 20.00, 'category', '2026-03-01', '2026-12-31', 1),
(2, 'Free Delivery Weekend', 'free_delivery', NULL, 'restaurant', '2026-03-31', '2026-04-02', 1);

-- 10. SEED DELIVERY PARTNERS
INSERT INTO delivery_partners (name, phone_number, vehicle_type, is_available, avg_rating)
VALUES 
('Rahim Delivery', '01511999991', 'Bike', 1, 4.80),
('Karim Logistics', '01511999992', 'Cycle', 1, 4.50);


-- 11. SEED CART & CART ITEMS
-- Customer 1 has a cart at Restaurant 1
INSERT INTO cart (customer_id, restaurant_id, status) VALUES (1, 1, 'active');
INSERT INTO cart_items (cart_id, item_id, quantity, unit_price) VALUES (1, 1, 2, 450.00);

-- 12. SEED ORDERS, DETAILS, & PAYMENTS
-- Order 1: Completed
INSERT INTO orders (customer_id, restaurant_id, cart_id, delivery_address_id, order_status, subtotal, discount_amount, delivery_fee, total_amount)
VALUES (1, 1, NULL, 1, 'delivered', 900.00, 0.00, 50.00, 950.00);

INSERT INTO order_details (order_id, item_id, quantity, unit_price_at_order, line_total)
VALUES (1, 1, 2, 450.00, 900.00);

INSERT INTO payments (order_id, customer_id, payment_method, payment_status, amount_paid, transaction_ref)
VALUES (1, 1, 'bkash', 'paid', 950.00, 'TRX-100200300');

-- 13. SEED DELIVERIES
INSERT INTO deliveries (order_id, partner_id, delivery_address_id, delivery_status, delivered_time)
VALUES (1, 1, 1, 'delivered', GETDATE());

-- 14. SEED REVIEWS
INSERT INTO reviews (order_id, customer_id, restaurant_id, partner_id, restaurant_rating, delivery_rating, comment)
VALUES (1, 1, 1, 1, 5, 5, 'The Kung Pao Chicken was excellent!');
