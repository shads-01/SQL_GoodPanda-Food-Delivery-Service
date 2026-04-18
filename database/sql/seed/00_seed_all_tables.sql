USE goodpanda_db;
GO

-- ============================================================
-- CLEANUP
-- ============================================================
DELETE FROM failed_jobs;
DELETE FROM reviews; 
DELETE FROM deliveries; 
DELETE FROM payments; 
DELETE FROM cart_items; 
DELETE FROM orders;
DELETE FROM cart; 
DELETE FROM offers;
DELETE FROM menu_items; 
DELETE FROM menu_categories;
DELETE FROM restaurant_ratings; 
DELETE FROM restaurant_cuisines; 
DELETE FROM cuisine_types;
DELETE FROM restaurants; 
DELETE FROM customer_addresses;
DELETE FROM customer_profiles; 
DELETE FROM restaurant_owner_profiles; 
DELETE FROM delivery_partner_profiles;
DELETE FROM users;

DBCC CHECKIDENT ('users', RESEED, 0);
DBCC CHECKIDENT ('restaurants', RESEED, 0);
DBCC CHECKIDENT ('cuisine_types', RESEED, 0);
DBCC CHECKIDENT ('menu_categories', RESEED, 0);
DBCC CHECKIDENT ('menu_items', RESEED, 0);
DBCC CHECKIDENT ('offers', RESEED, 0);
DBCC CHECKIDENT ('orders', RESEED, 0);
DBCC CHECKIDENT ('cart', RESEED, 0);
DBCC CHECKIDENT ('deliveries', RESEED, 0);


-- ============================================================
-- 1. USERS
-- ============================================================
-- All passwords are set to 'password' using hash $2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6

INSERT INTO users (role, name, email, phone_number, password, is_active, created_at)
VALUES 
-- Customers
('customer', 'Shahadat Hasan', 'shahadat@example.com', '01711000001', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('customer', 'John Doe', 'john@customer.com', '01811000002', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('customer', 'Sarah Connor', 'sarah@customer.com', '01911000003', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('customer', 'Mike Tyson', 'mike@customer.com', '01611000004', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('customer', 'Emily Blunt', 'emily@customer.com', '01511000005', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('customer', 'David Beckham', 'david@customer.com', '01722000006', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('customer', 'Lisa Kudrow', 'lisa@customer.com', '01822000007', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('customer', 'James Bond', 'james@customer.com', '01922000008', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('customer', 'Anna Smith', 'anna@customer.com', '01622000009', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('customer', 'Robert Stark', 'robert@customer.com', '01522000010', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('customer', 'Walter White', 'walter@customer.com', '01733000011', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('customer', 'Jesse Pinkman', 'jesse@customer.com', '01833000012', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('customer', 'Saul Goodman', 'saul@customer.com', '01933000013', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('customer', 'Gus Fring', 'gus@customer.com', '01633000014', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('customer', 'Mike Ehrmantraut','mike.e@customer.com','01533000015', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),

-- Owners
('restaurant_owner', 'Lab Instructor', 'instructor@aust.edu', '01744000001', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('restaurant_owner', 'Jane Smith', 'jane@owner.com', '01844000002', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('restaurant_owner', 'Mario Rossi', 'mario@owner.com', '01944000003', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('restaurant_owner', 'Luigi Bros', 'luigi@owner.com', '01644000004', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('restaurant_owner', 'Gordon Ramsay', 'gordon@owner.com', '01544000005', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('restaurant_owner', 'Jamie Oliver', 'jamie@owner.com', '01755000006', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('restaurant_owner', 'Antony Bourn', 'antony@owner.com', '01855000007', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('restaurant_owner', 'Maria Garcia', 'maria@owner.com', '01955000008', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),

-- Riders
('delivery_partner', 'Rahim Delivery', 'rahim@rider.com', '01666000001', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('delivery_partner', 'Karim Logistics', 'karim@rider.com', '01566000002', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('delivery_partner', 'Jabbar Fast', 'jabbar@rider.com', '01766000003', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('delivery_partner', 'Salam Go', 'salam@rider.com', '01866000004', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE()),
('delivery_partner', 'Rafique Dash', 'rafique@rider.com', '01966000005', '$2y$12$sXPAVjM63yCR2UJOh.f20e.c4ag3R7PAv4S1clnBpOrsJRv02wXE6', 1, GETDATE());

-- ============================================================
-- 2. PROFILES
-- ============================================================
INSERT INTO customer_profiles (customer_id) SELECT id FROM users WHERE role = 'customer';
INSERT INTO restaurant_owner_profiles (owner_id) SELECT id FROM users WHERE role = 'restaurant_owner';

-- For Rahim Delivery, we'll assign some mock earnings from deliveries below (50 + 50 + 60 = 160)
INSERT INTO delivery_partner_profiles (partner_id, vehicle_type, is_available, avg_rating, total_earnings, created_at)
SELECT id, 'bike', 1, 4.80, 160.00, GETDATE() FROM users WHERE email = 'rahim@rider.com';

INSERT INTO delivery_partner_profiles (partner_id, vehicle_type, is_available, avg_rating, total_earnings, created_at)
SELECT id, 'scooter', 1, 4.50, 0.00, GETDATE() FROM users WHERE email IN ('karim@rider.com', 'jabbar@rider.com', 'salam@rider.com', 'rafique@rider.com');

-- ============================================================
-- 3. ADDRESSES
-- ============================================================
INSERT INTO customer_addresses (customer_id, label, address_line, city, is_default)
SELECT id, 'Home', '123 Main Street, Apt 4B', 'Dhaka', 1 FROM users WHERE role = 'customer';

INSERT INTO customer_addresses (customer_id, label, address_line, city, is_default)
SELECT id, 'Office', 'Crystal Tower, Road 11', 'Dhaka', 0 FROM users WHERE role = 'customer';

-- ============================================================
-- 4. CUISINES
-- ============================================================
INSERT INTO cuisine_types (cuisine_name, description, cuisine_image)
VALUES 
('Bengali', 'Traditional local dishes', 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=800'),
('Chinese', 'Cantonese and Szechuan style', 'https://images.unsplash.com/photo-1516684732162-798a0062be99?w=800'),
('Italian', 'Pizza, Pasta, and more', 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?w=800'),
('Fast Food', 'Burgers, Fries, and Quick Bites', 'https://images.unsplash.com/photo-1561758033-d89a9ad46330?w=800'),
('Mexican', 'Tacos, Nachos, and Spices', 'https://images.unsplash.com/photo-1513456852971-30c0b8199d4d?w=800'),
('Thai', 'Sweet, Spicy, and Sour', 'https://images.unsplash.com/photo-1559314809-0d155014e29e?w=800'),
('Japanese', 'Sushi, Ramen, and Bento', 'https://images.unsplash.com/photo-1580822184713-364e5d140e69?w=800'),
('Indian', 'Curries and Tandoori', 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?w=800');

-- ============================================================
-- 5. RESTAURANTS
-- ============================================================
INSERT INTO restaurants (owner_id, name, location, phone_number, profile_image, cover_image, open_status, created_at)
SELECT id, 'Panda Express', 'Banani, Dhaka', '01711000010', 'panda_logo.png', 'https://images.unsplash.com/photo-1552566626-52f8b828add9?w=800', 1, GETDATE() FROM users WHERE email = 'instructor@aust.edu';

INSERT INTO restaurants (owner_id, name, location, phone_number, profile_image, cover_image, open_status, created_at)
SELECT id, 'Burger King', 'Uttara, Dhaka', '01711000012', 'bk_logo.png', 'https://images.unsplash.com/photo-1571091718767-18b5b1457add?w=800', 1, GETDATE() FROM users WHERE email = 'jane@owner.com';

INSERT INTO restaurants (owner_id, name, location, phone_number, profile_image, cover_image, open_status, created_at)
SELECT id, 'Luigis Pizza', 'Gulshan, Dhaka', '01611000015', 'pizza_logo.png', 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=800', 1, GETDATE() FROM users WHERE email = 'mario@owner.com';

INSERT INTO restaurants (owner_id, name, location, phone_number, profile_image, cover_image, open_status, created_at)
SELECT id, 'Sushi Master', 'Dhanmondi, Dhaka', '01611000016', 'sushi_logo.png', 'https://images.unsplash.com/photo-1579871494447-9811cf80d66c?w=800', 1, GETDATE() FROM users WHERE email = 'luigi@owner.com';

INSERT INTO restaurants (owner_id, name, location, phone_number, profile_image, cover_image, open_status, created_at)
SELECT id, 'Hells Kitchen', 'Mirpur, Dhaka', '01611000017', 'steak_logo.png', 'https://images.unsplash.com/photo-1552332386-f8dd00dc2f85?w=800', 1, GETDATE() FROM users WHERE email = 'gordon@owner.com';

INSERT INTO restaurants (owner_id, name, location, phone_number, profile_image, cover_image, open_status, created_at)
SELECT id, 'Naked Chef Deli', 'Baily Road, Dhaka', '01611000018', 'deli_logo.png', 'https://images.unsplash.com/photo-1550950158-d0d960dff51b?w=800', 1, GETDATE() FROM users WHERE email = 'jamie@owner.com';

INSERT INTO restaurants (owner_id, name, location, phone_number, profile_image, cover_image, open_status, created_at)
SELECT id, 'Bangla Spice', 'Puran Dhaka', '01611000019', 'spice_logo.png', 'https://images.unsplash.com/photo-1589302168068-964664d93dc0?w=800', 1, GETDATE() FROM users WHERE email = 'antony@owner.com';

INSERT INTO restaurants (owner_id, name, location, phone_number, profile_image, cover_image, open_status, created_at)
SELECT id, 'Mexican Fiesta', 'Mohakhali, Dhaka', '01611000020', 'taco_logo.png', 'https://images.unsplash.com/photo-1552332386-f8dd00dc2f85?w=800', 1, GETDATE() FROM users WHERE email = 'maria@owner.com';

-- Give each restaurant a different rating and review count
INSERT INTO restaurant_ratings (restaurant_id, avg_rating, total_reviews) VALUES
	((SELECT restaurant_id FROM restaurants WHERE name = 'Panda Express'), 4.9, 150),
	((SELECT restaurant_id FROM restaurants WHERE name = 'Burger King'), 4.4, 95),
	((SELECT restaurant_id FROM restaurants WHERE name = 'Luigis Pizza'), 4.0, 210),
	((SELECT restaurant_id FROM restaurants WHERE name = 'Sushi Master'), 4.1, 180),
	((SELECT restaurant_id FROM restaurants WHERE name = 'Hells Kitchen'), 4.2, 75),
	((SELECT restaurant_id FROM restaurants WHERE name = 'Naked Chef Deli'), 4.3, 60),
	((SELECT restaurant_id FROM restaurants WHERE name = 'Bangla Spice'), 4.6, 130),
	((SELECT restaurant_id FROM restaurants WHERE name = 'Mexican Fiesta'), 3.9, 110);


-- ============================================================
-- 6. RESTAURANT-CUISINE LINKS
-- ============================================================
INSERT INTO restaurant_cuisines (restaurant_id, cuisine_id) SELECT r.restaurant_id, c.cuisine_id FROM restaurants r, cuisine_types c WHERE r.name = 'Panda Express' AND c.cuisine_name = 'Chinese';
INSERT INTO restaurant_cuisines (restaurant_id, cuisine_id) SELECT r.restaurant_id, c.cuisine_id FROM restaurants r, cuisine_types c WHERE r.name = 'Burger King' AND c.cuisine_name = 'Fast Food';
INSERT INTO restaurant_cuisines (restaurant_id, cuisine_id) SELECT r.restaurant_id, c.cuisine_id FROM restaurants r, cuisine_types c WHERE r.name = 'Luigis Pizza' AND c.cuisine_name = 'Italian';
INSERT INTO restaurant_cuisines (restaurant_id, cuisine_id) SELECT r.restaurant_id, c.cuisine_id FROM restaurants r, cuisine_types c WHERE r.name = 'Sushi Master' AND c.cuisine_name = 'Japanese';
INSERT INTO restaurant_cuisines (restaurant_id, cuisine_id) SELECT r.restaurant_id, c.cuisine_id FROM restaurants r, cuisine_types c WHERE r.name = 'Hells Kitchen' AND c.cuisine_name = 'Fast Food';
INSERT INTO restaurant_cuisines (restaurant_id, cuisine_id) SELECT r.restaurant_id, c.cuisine_id FROM restaurants r, cuisine_types c WHERE r.name = 'Naked Chef Deli' AND c.cuisine_name = 'Italian';
INSERT INTO restaurant_cuisines (restaurant_id, cuisine_id) SELECT r.restaurant_id, c.cuisine_id FROM restaurants r, cuisine_types c WHERE r.name = 'Bangla Spice' AND c.cuisine_name = 'Bengali';
INSERT INTO restaurant_cuisines (restaurant_id, cuisine_id) SELECT r.restaurant_id, c.cuisine_id FROM restaurants r, cuisine_types c WHERE r.name = 'Mexican Fiesta' AND c.cuisine_name = 'Mexican';

-- ============================================================
-- 7. MENU CATEGORIES
-- ============================================================
INSERT INTO menu_categories (restaurant_id, category_name, display_order) SELECT restaurant_id, 'Appetizers', 1 FROM restaurants;
INSERT INTO menu_categories (restaurant_id, category_name, display_order) SELECT restaurant_id, 'Main Course', 2 FROM restaurants;
INSERT INTO menu_categories (restaurant_id, category_name, display_order) SELECT restaurant_id, 'Desserts', 3 FROM restaurants;
INSERT INTO menu_categories (restaurant_id, category_name, display_order) SELECT restaurant_id, 'Beverages', 4 FROM restaurants;

-- ============================================================
-- 8. MENU ITEMS
-- ============================================================
-- (We'll use variables to dynamically find the correct category IDs for each restaurant to keep foreign keys completely robust)

DECLARE @r_panda INT, @r_bk INT, @r_luigi INT, @r_sushi INT, @r_gordon INT, @r_jamie INT, @r_spice INT, @r_mex INT;
SELECT @r_panda = restaurant_id FROM restaurants WHERE name = 'Panda Express';
SELECT @r_bk = restaurant_id    FROM restaurants WHERE name = 'Burger King';
SELECT @r_luigi = restaurant_id FROM restaurants WHERE name = 'Luigis Pizza';
SELECT @r_sushi = restaurant_id FROM restaurants WHERE name = 'Sushi Master';
SELECT @r_gordon = restaurant_id FROM restaurants WHERE name = 'Hells Kitchen';
SELECT @r_jamie = restaurant_id FROM restaurants WHERE name = 'Naked Chef Deli';
SELECT @r_spice = restaurant_id FROM restaurants WHERE name = 'Bangla Spice';
SELECT @r_mex = restaurant_id   FROM restaurants WHERE name = 'Mexican Fiesta';

DECLARE @c_chinese INT, @c_ff INT, @c_italian INT, @c_japanese INT, @c_bengali INT, @c_mexican INT;
SELECT @c_chinese = cuisine_id FROM cuisine_types WHERE cuisine_name = 'Chinese';
SELECT @c_ff = cuisine_id FROM cuisine_types WHERE cuisine_name = 'Fast Food';
SELECT @c_italian = cuisine_id FROM cuisine_types WHERE cuisine_name = 'Italian';
SELECT @c_japanese = cuisine_id FROM cuisine_types WHERE cuisine_name = 'Japanese';
SELECT @c_bengali = cuisine_id FROM cuisine_types WHERE cuisine_name = 'Bengali';
SELECT @c_mexican = cuisine_id FROM cuisine_types WHERE cuisine_name = 'Mexican';

-- Panda Express Items
INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
VALUES 
(@r_panda, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_panda AND category_name='Main Course'), @c_chinese, 'Kung Pao Chicken', 'Spicy diced chicken', 'https://images.unsplash.com/photo-1525755662778-989d0524087e?w=400', 450, 1, GETDATE()),
(@r_panda, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_panda AND category_name='Appetizers'), @c_chinese, 'Spring Rolls', 'Crispy vegetarian rolls', 'https://images.unsplash.com/photo-1541696432-82c6da8ce7bf?w=400', 180, 1, GETDATE()),
(@r_panda, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_panda AND category_name='Main Course'), @c_chinese, 'Chow Mein', 'Vegetable stir-fry noodles', 'https://images.unsplash.com/photo-1585032226651-759b368d7246?w=400', 320, 1, GETDATE()),
(@r_panda, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_panda AND category_name='Beverages'), @c_chinese, 'Jasmine Tea', 'Hot traditional tea', 'https://images.unsplash.com/photo-1576092762791-dd9e2220abd4?w=400', 120, 1, GETDATE()),
(@r_panda, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_panda AND category_name='Main Course'), @c_chinese, 'Sweet Sour Prawn', 'Crispy prawns with glaze', 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=400', 650, 1, GETDATE()),
(@r_panda, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_panda AND category_name='Desserts'), @c_chinese, 'Fortune Cookie', 'Classic fortune cookie', 'https://images.unsplash.com/photo-1558293739-16631ad1900a?w=400', 50, 1, GETDATE());

-- Burger King
INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
VALUES 
(@r_bk, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_bk AND category_name='Main Course'), @c_ff, 'Whopper', 'Flame-grilled beef burger', 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400', 550, 1, GETDATE()),
(@r_bk, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_bk AND category_name='Appetizers'), @c_ff, 'French Fries', 'Crispy golden fries', 'https://images.unsplash.com/photo-1573080496599-c73663b9f485?w=400', 200, 1, GETDATE()),
(@r_bk, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_bk AND category_name='Main Course'), @c_ff, 'Chicken Royale', 'Crispy chicken sandwich', 'https://images.unsplash.com/photo-1625813506062-0aeb1d7a094b?w=400', 450, 1, GETDATE()),
(@r_bk, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_bk AND category_name='Beverages'), @c_ff, 'Cola', 'Chilled carbonated drink', 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?w=400', 100, 1, GETDATE()),
(@r_bk, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_bk AND category_name='Appetizers'), @c_ff, 'Onion Rings', 'Fried battered onion', 'https://images.unsplash.com/photo-1639024470295-8800160d2bbf?w=400', 220, 1, GETDATE()),
(@r_bk, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_bk AND category_name='Desserts'), @c_ff, 'Sundae', 'Ice cream with syrup', 'https://images.unsplash.com/photo-1563805042-7684c8e9e533?w=400', 180, 1, GETDATE());

-- Luigis 
INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
VALUES 
(@r_luigi, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_luigi AND category_name='Main Course'), @c_italian, 'Margherita Pizza', 'Tomato, Basil, Mozzarella', 'https://images.unsplash.com/photo-1604068549290-dea0e4a305ca?w=400', 850, 1, GETDATE()),
(@r_luigi, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_luigi AND category_name='Appetizers'), @c_italian, 'Garlic Bread', 'Buttery baguette with herbs', 'https://images.unsplash.com/photo-1573140247632-f8fd74997d5c?w=400', 220, 1, GETDATE()),
(@r_luigi, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_luigi AND category_name='Main Course'), @c_italian, 'Carbonara Pasta', 'Creamy egg and bacon pasta', 'https://images.unsplash.com/photo-1612874742237-6526221588e3?w=400', 780, 1, GETDATE()),
(@r_luigi, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_luigi AND category_name='Main Course'), @c_italian, 'Pepperoni Feast', 'Double pepperoni & cheese', 'https://images.unsplash.com/photo-1628840042765-356cda07504e?w=400', 1050, 1, GETDATE()),
(@r_luigi, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_luigi AND category_name='Desserts'), @c_italian, 'Tiramisu', 'Coffee-flavored cake', 'https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?w=400', 450, 1, GETDATE());

-- Sushi Master
INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
VALUES 
(@r_sushi, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_sushi AND category_name='Main Course'), @c_japanese, 'Salmon Sushi Set', 'Fresh raw salmon', 'https://images.unsplash.com/photo-1579871494447-9811cf80d66c?w=400', 1200, 1, GETDATE()),
(@r_sushi, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_sushi AND category_name='Main Course'), @c_japanese, 'Spicy Tuna Roll', 'Rolled sushi with tuna', 'https://images.unsplash.com/photo-1553621042-f6e147245754?w=400', 900, 1, GETDATE()),
(@r_sushi, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_sushi AND category_name='Appetizers'), @c_japanese, 'Edamame', 'Steamed soybeans', 'https://images.unsplash.com/photo-1619421528625-3b95a89ded80?w=400', 300, 1, GETDATE()),
(@r_sushi, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_sushi AND category_name='Main Course'), @c_japanese, 'Beef Ramen', 'Rich broth with noodles', 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=400', 850, 1, GETDATE()),
(@r_sushi, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_sushi AND category_name='Desserts'), @c_japanese, 'Mochi Ice Cream', 'Sticky rice with ice cream', 'https://images.unsplash.com/photo-1563805042-7684c8e9e533?w=400', 350, 1, GETDATE());

-- Hells Kitchen
INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
VALUES 
(@r_gordon, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_gordon AND category_name='Main Course'), @c_italian, 'Beef Wellington', 'Signature steak in pastry', 'https://images.unsplash.com/photo-1558030006-450675393462?w=400', 2500, 1, GETDATE()),
(@r_gordon, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_gordon AND category_name='Main Course'), @c_italian, 'Seared Scallops', 'Ocean-fresh diver scallops', 'https://images.unsplash.com/photo-1599084949219-c0ae2463e262?w=400', 1800, 1, GETDATE()),
(@r_gordon, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_gordon AND category_name='Desserts'), @c_italian, 'Sticky Toffee Pudding', 'Warm date cake', 'https://images.unsplash.com/photo-1551024601-bec78aea704b?w=400', 600, 1, GETDATE());

-- Bangla Spice
INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
VALUES 
(@r_spice, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_spice AND category_name='Main Course'), @c_bengali, 'Kacchi Biryani', 'Basmati rice with mutton', 'https://images.unsplash.com/photo-1633945274405-b6c8069047b0?w=400', 450, 1, GETDATE()),
(@r_spice, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_spice AND category_name='Main Course'), @c_bengali, 'Beef Kala Bhuna', 'Traditional slow-cooked beef', 'https://images.unsplash.com/photo-1512058560566-403a77a13a2d?w=400', 550, 1, GETDATE()),
(@r_spice, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_spice AND category_name='Main Course'), @c_bengali, 'Chicken Roast', 'Rich onion gravy chicken', 'https://images.unsplash.com/photo-1598103442097-8b74394b95c6?w=400', 250, 1, GETDATE()),
(@r_spice, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_spice AND category_name='Beverages'), @c_bengali, 'Borhani', 'Spiced yogurt drink', 'https://images.unsplash.com/photo-1544145945-f90425340c7e?w=400', 100, 1, GETDATE()),
(@r_spice, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_spice AND category_name='Desserts'), @c_bengali, 'Misty Doi', 'Sweet yogurt dessert', 'https://images.unsplash.com/photo-1559181567-c3190ca9959b?w=400', 120, 1, GETDATE());

-- Mexican Fiesta
INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
VALUES 
(@r_mex, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_mex AND category_name='Main Course'), @c_mexican, 'Beef Tacos', 'Hard shell ground beef tacos', 'https://images.unsplash.com/photo-1552332386-f8dd00dc2f85?w=400', 350, 1, GETDATE()),
(@r_mex, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_mex AND category_name='Main Course'), @c_mexican, 'Chicken Burrito', 'Wrapped tortilla heavy filling', 'https://images.unsplash.com/photo-1566412173167-e9aeb2405fc6?w=400', 450, 1, GETDATE()),
(@r_mex, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_mex AND category_name='Appetizers'), @c_mexican, 'Nachos Supreme', 'Loaded cheese nachos', 'https://images.unsplash.com/photo-1513456852971-30c0b8199d4d?w=400', 400, 1, GETDATE()),
(@r_mex, (SELECT category_id FROM menu_categories WHERE restaurant_id=@r_mex AND category_name='Desserts'), @c_mexican, 'Churros', 'Fried dough pastry', 'https://images.unsplash.com/photo-1624371414361-e670ead10bc1?w=400', 250, 1, GETDATE());

-- ============================================================
-- 9. OFFERS
-- ============================================================
-- Will assign specific item IDs, wait, using top 1 per name is safer for foreign keys
DECLARE @i_kacchi INT, @i_whopper INT, @i_pizza INT, @i_taco INT;
SELECT TOP 1 @i_kacchi = item_id FROM menu_items WHERE item_name = 'Kacchi Biryani';
SELECT TOP 1 @i_whopper = item_id FROM menu_items WHERE item_name = 'Whopper';
SELECT TOP 1 @i_pizza = item_id FROM menu_items WHERE item_name = 'Margherita Pizza';
SELECT TOP 1 @i_taco = item_id FROM menu_items WHERE item_name = 'Beef Tacos';

INSERT INTO offers (restaurant_id, offer_title, discount_type, discount_value, target_type, target_item_id, start_datetime, end_datetime, is_active, created_at)
VALUES 
(@r_bk, 'Whopper Wednesday 20% Off', 'percentage', 20.00, 'item', @i_whopper, DATEADD(day, -5, GETDATE()), DATEADD(day, 10, GETDATE()), 1, GETDATE()),
(@r_spice, 'Festive Biryani Deal', 'flat', 50.00, 'item', @i_kacchi, DATEADD(day, -2, GETDATE()), DATEADD(day, 30, GETDATE()), 1, GETDATE()),
(@r_luigi, 'Pizza Party 15%', 'percentage', 15.00, 'item', @i_pizza, DATEADD(day, -10, GETDATE()), DATEADD(day, 5, GETDATE()), 1, GETDATE()),
(@r_mex, 'Taco Tuesday', 'percentage', 25.00, 'item', @i_taco, DATEADD(day, -1, GETDATE()), DATEADD(day, 14, GETDATE()), 1, GETDATE()),


-- Expired offer
(@r_panda, 'Winter Special', 'percentage', 30.00, 'item', NULL, DATEADD(day, -30, GETDATE()), DATEADD(day, -5, GETDATE()), 0, GETDATE());

-- ============================================================
-- 10. ORDERS & REVIEWS (DYNAMIC GENERATION)
-- ============================================================
PRINT 'Generating dynamic orders and reviews...';

DECLARE @cust_id BIGINT, @rest_id INT, @addr_id BIGINT, @order_id INT, @cart_id INT;
DECLARE @counter INT = 0;

-- Cursor to iterate through all customers
DECLARE cust_cur CURSOR FOR SELECT customer_id FROM customer_profiles;
OPEN cust_cur;
FETCH NEXT FROM cust_cur INTO @cust_id;

WHILE @@FETCH_STATUS = 0
BEGIN
    -- For each customer, place orders at 4 random restaurants
    DECLARE rest_cur CURSOR FOR SELECT TOP 4 restaurant_id FROM restaurants ORDER BY NEWID();
    OPEN rest_cur;
    FETCH NEXT FROM rest_cur INTO @rest_id;
    
    WHILE @@FETCH_STATUS = 0
    BEGIN
        SELECT TOP 1 @addr_id = address_id FROM customer_addresses WHERE customer_id = @cust_id;
        
        -- Create Cart (Mock for Seed)
        INSERT INTO cart (customer_id, restaurant_id, status) VALUES (@cust_id, @rest_id, 'converted_to_order');
        SET @cart_id = SCOPE_IDENTITY();
        
        -- Add to Cart Items
        INSERT INTO cart_items (cart_id, item_id, quantity, unit_price)
        SELECT TOP 2 @cart_id, item_id, 1, price FROM menu_items WHERE restaurant_id = @rest_id ORDER BY NEWID();

        -- Create Order
        INSERT INTO orders (customer_id, restaurant_id, cart_id, delivery_address_id, order_datetime, order_status, subtotal, discount_amount, delivery_fee, total_amount)
        VALUES (@cust_id, @rest_id, @cart_id, @addr_id, DATEADD(DAY, -1 * (ABS(CHECKSUM(NEWID())) % 30), GETDATE()), 'delivered', 450.00, 0, 50.00, 500.00);
        
        SET @order_id = SCOPE_IDENTITY();

        -- Create Payment record
        INSERT INTO payments (order_id, customer_id, payment_method, payment_status, amount_paid, transaction_ref)
        VALUES (@order_id, @cust_id, 'cash', 'paid', 500.00, NEWID());
        
        -- Create Review
        INSERT INTO reviews (order_id, customer_id, restaurant_id, restaurant_rating, comment, review_datetime)
        VALUES (
            @order_id, 
            @cust_id, 
            @rest_id, 
            3 + (ABS(CHECKSUM(NEWID())) % 3), -- Random rating 3, 4, or 5
            CASE (ABS(CHECKSUM(NEWID())) % 5)
                WHEN 0 THEN 'Amazing food! Highly recommended.'
                WHEN 1 THEN 'Really enjoyed the meal, will order again.'
                WHEN 2 THEN 'Good service and fresh ingredients.'
                WHEN 3 THEN 'Tasted great, but delivery was a bit slow.'
                ELSE 'Standard quality, overall satisfied.'
            END,
            DATEADD(MINUTE, 60 + (ABS(CHECKSUM(NEWID())) % 120), (SELECT order_datetime FROM orders WHERE order_id = @order_id))
        );
        
        FETCH NEXT FROM rest_cur INTO @rest_id;
    END
    CLOSE rest_cur;
    DEALLOCATE rest_cur;

    FETCH NEXT FROM cust_cur INTO @cust_id;
END
CLOSE cust_cur;
DEALLOCATE cust_cur;

-- ============================================================
-- 11. RECALCULATE RATINGS
-- ============================================================
PRINT 'Recalculating restaurant ratings based on generated reviews...';

UPDATE rr
SET 
    avg_rating = ISNULL((SELECT AVG(CAST(restaurant_rating AS DECIMAL(3,2))) FROM reviews WHERE restaurant_id = rr.restaurant_id), 0.00),
    total_reviews = (SELECT COUNT(*) FROM reviews WHERE restaurant_id = rr.restaurant_id)
FROM restaurant_ratings rr;

-- ============================================================
-- 12. DELIVERIES (MOCK FOR RECENT ORDERS)
-- ============================================================
PRINT 'Assigning mock deliveries...';

INSERT INTO deliveries (order_id, partner_id, delivery_address_id, delivery_status, pickup_time, delivered_time)
SELECT TOP 20 
    o.order_id, 
    (SELECT TOP 1 id FROM users WHERE role = 'delivery_partner' ORDER BY NEWID()), 
    o.delivery_address_id, 
    'delivered',
    DATEADD(MINUTE, 10, o.order_datetime),
    DATEADD(MINUTE, 40, o.order_datetime)
FROM orders o
WHERE o.order_status = 'delivered';

-- ============================================================
-- DONE
-- ============================================================
PRINT 'Seed generation complete: Massively populated tables with realistic reviews and histories.';
GO
