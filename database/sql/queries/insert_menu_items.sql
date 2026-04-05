-- ============================================================
-- INSERT MULTIPLE MENU ITEMS FOR YUM CHA RESTAURANT
-- ============================================================
USE goodpanda_db;
GO

-- First, let's add more categories for Yum Cha
INSERT INTO menu_categories (restaurant_id, category_name, display_order)
SELECT r.restaurant_id, 'Dim Sum', 1 FROM restaurants r WHERE r.name = 'Yum Cha' AND NOT EXISTS (SELECT 1 FROM menu_categories mc WHERE mc.restaurant_id = r.restaurant_id AND mc.category_name = 'Dim Sum');

INSERT INTO menu_categories (restaurant_id, category_name, display_order)
SELECT r.restaurant_id, 'Noodles & Rice', 2 FROM restaurants r WHERE r.name = 'Yum Cha' AND NOT EXISTS (SELECT 1 FROM menu_categories mc WHERE mc.restaurant_id = r.restaurant_id AND mc.category_name = 'Noodles & Rice');

INSERT INTO menu_categories (restaurant_id, category_name, display_order)
SELECT r.restaurant_id, 'Main Courses', 3 FROM restaurants r WHERE r.name = 'Yum Cha' AND NOT EXISTS (SELECT 1 FROM menu_categories mc WHERE mc.restaurant_id = r.restaurant_id AND mc.category_name = 'Main Courses');

INSERT INTO menu_categories (restaurant_id, category_name, display_order)
SELECT r.restaurant_id, 'Desserts', 4 FROM restaurants r WHERE r.name = 'Yum Cha' AND NOT EXISTS (SELECT 1 FROM menu_categories mc WHERE mc.restaurant_id = r.restaurant_id AND mc.category_name = 'Desserts');

INSERT INTO menu_categories (restaurant_id, category_name, display_order)
SELECT r.restaurant_id, 'Beverages', 5 FROM restaurants r WHERE r.name = 'Yum Cha' AND NOT EXISTS (SELECT 1 FROM menu_categories mc WHERE mc.restaurant_id = r.restaurant_id AND mc.category_name = 'Beverages');

GO

-- ============================================================
-- YUM CHA MENU ITEMS
-- ============================================================

-- Dim Sum Items
INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
SELECT r.restaurant_id, mc.category_id, ct.cuisine_id, 'Har Gow (Shrimp Dumplings)', 'Translucent dumplings filled with fresh shrimp', 'har_gow.jpg', 180.00, 1, GETDATE()
FROM restaurants r, menu_categories mc, cuisine_types ct
WHERE r.name = 'Yum Cha' AND mc.category_name = 'Dim Sum' AND ct.cuisine_name = 'Chinese';

INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
SELECT r.restaurant_id, mc.category_id, ct.cuisine_id, 'Siu Mai (Pork Dumplings)', 'Open-faced dumplings with pork and shrimp', 'siu_mai.jpg', 160.00, 1, GETDATE()
FROM restaurants r, menu_categories mc, cuisine_types ct
WHERE r.name = 'Yum Cha' AND mc.category_name = 'Dim Sum' AND ct.cuisine_name = 'Chinese';

INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
SELECT r.restaurant_id, mc.category_id, ct.cuisine_id, 'Char Siu Bao (BBQ Pork Buns)', 'Sweet and savory steamed buns with BBQ pork', 'char_siu_bao.jpg', 140.00, 1, GETDATE()
FROM restaurants r, menu_categories mc, cuisine_types ct
WHERE r.name = 'Yum Cha' AND mc.category_name = 'Dim Sum' AND ct.cuisine_name = 'Chinese';

INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
SELECT r.restaurant_id, mc.category_id, ct.cuisine_id, 'Cheung Fun (Rice Noodle Rolls)', 'Steamed rice noodle rolls with various fillings', 'cheung_fun.jpg', 120.00, 1, GETDATE()
FROM restaurants r, menu_categories mc, cuisine_types ct
WHERE r.name = 'Yum Cha' AND mc.category_name = 'Dim Sum' AND ct.cuisine_name = 'Chinese';

INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
SELECT r.restaurant_id, mc.category_id, ct.cuisine_id, 'Spring Rolls', 'Crispy rolls with vegetables and glass noodles', 'spring_rolls.jpg', 100.00, 1, GETDATE()
FROM restaurants r, menu_categories mc, cuisine_types ct
WHERE r.name = 'Yum Cha' AND mc.category_name = 'Dim Sum' AND ct.cuisine_name = 'Chinese';

INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
SELECT r.restaurant_id, mc.category_id, ct.cuisine_id, 'Egg Tarts', 'Classic Portuguese-style custard tarts', 'egg_tarts.jpg', 90.00, 1, GETDATE()
FROM restaurants r, menu_categories mc, cuisine_types ct
WHERE r.name = 'Yum Cha' AND mc.category_name = 'Dim Sum' AND ct.cuisine_name = 'Chinese';

-- Noodles & Rice
INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
SELECT r.restaurant_id, mc.category_id, ct.cuisine_id, 'Wonton Noodle Soup', 'Hand-pulled noodles with wontons in savory broth', 'wonton_noodles.jpg', 220.00, 1, GETDATE()
FROM restaurants r, menu_categories mc, cuisine_types ct
WHERE r.name = 'Yum Cha' AND mc.category_name = 'Noodles & Rice' AND ct.cuisine_name = 'Chinese';

INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
SELECT r.restaurant_id, mc.category_id, ct.cuisine_id, 'Beef Chow Fun', 'Wide rice noodles stir-fried with beef and vegetables', 'beef_chow_fun.jpg', 250.00, 1, GETDATE()
FROM restaurants r, menu_categories mc, cuisine_types ct
WHERE r.name = 'Yum Cha' AND mc.category_name = 'Noodles & Rice' AND ct.cuisine_name = 'Chinese';

INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
SELECT r.restaurant_id, mc.category_id, ct.cuisine_id, 'Yangzhou Fried Rice', 'Classic fried rice with shrimp, pork, and vegetables', 'yangzhou_rice.jpg', 200.00, 1, GETDATE()
FROM restaurants r, menu_categories mc, cuisine_types ct
WHERE r.name = 'Yum Cha' AND mc.category_name = 'Noodles & Rice' AND ct.cuisine_name = 'Chinese';

INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
SELECT r.restaurant_id, mc.category_id, ct.cuisine_id, 'Dan Dan Noodles', 'Spicy Sichuan noodles with ground pork and sesame', 'dan_dan.jpg', 180.00, 1, GETDATE()
FROM restaurants r, menu_categories mc, cuisine_types ct
WHERE r.name = 'Yum Cha' AND mc.category_name = 'Noodles & Rice' AND ct.cuisine_name = 'Chinese';

-- Main Courses
INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
SELECT r.restaurant_id, mc.category_id, ct.cuisine_id, 'Sweet and Sour Pork', 'Crispy pork with pineapple in sweet and sour sauce', 'sweet_sour_pork.jpg', 320.00, 1, GETDATE()
FROM restaurants r, menu_categories mc, cuisine_types ct
WHERE r.name = 'Yum Cha' AND mc.category_name = 'Main Courses' AND ct.cuisine_name = 'Chinese';

INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
SELECT r.restaurant_id, mc.category_id, ct.cuisine_id, 'Kung Pao Chicken', 'Spicy chicken with peanuts and vegetables', 'kung_pao_chicken.jpg', 280.00, 1, GETDATE()
FROM restaurants r, menu_categories mc, cuisine_types ct
WHERE r.name = 'Yum Cha' AND mc.category_name = 'Main Courses' AND ct.cuisine_name = 'Chinese';

INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
SELECT r.restaurant_id, mc.category_id, ct.cuisine_id, 'Mapo Tofu', 'Spicy Sichuan tofu with ground pork', 'mapo_tofu.jpg', 240.00, 1, GETDATE()
FROM restaurants r, menu_categories mc, cuisine_types ct
WHERE r.name = 'Yum Cha' AND mc.category_name = 'Main Courses' AND ct.cuisine_name = 'Chinese';

INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
SELECT r.restaurant_id, mc.category_id, ct.cuisine_id, 'Peking Duck', 'Crispy duck with pancakes, scallions, and hoisin sauce', 'peking_duck.jpg', 450.00, 1, GETDATE()
FROM restaurants r, menu_categories mc, cuisine_types ct
WHERE r.name = 'Yum Cha' AND mc.category_name = 'Main Courses' AND ct.cuisine_name = 'Chinese';

-- Desserts
INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
SELECT r.restaurant_id, mc.category_id, ct.cuisine_id, 'Mango Pudding', 'Smooth and creamy mango pudding', 'mango_pudding.jpg', 120.00, 1, GETDATE()
FROM restaurants r, menu_categories mc, cuisine_types ct
WHERE r.name = 'Yum Cha' AND mc.category_name = 'Desserts' AND ct.cuisine_name = 'Chinese';

INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
SELECT r.restaurant_id, mc.category_id, ct.cuisine_id, 'Red Bean Soup', 'Sweet red bean soup with lotus seeds', 'red_bean_soup.jpg', 100.00, 1, GETDATE()
FROM restaurants r, menu_categories mc, cuisine_types ct
WHERE r.name = 'Yum Cha' AND mc.category_name = 'Desserts' AND ct.cuisine_name = 'Chinese';

INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
SELECT r.restaurant_id, mc.category_id, ct.cuisine_id, 'Sesame Balls', 'Deep-fried glutinous rice balls with sweet filling', 'sesame_balls.jpg', 110.00, 1, GETDATE()
FROM restaurants r, menu_categories mc, cuisine_types ct
WHERE r.name = 'Yum Cha' AND mc.category_name = 'Desserts' AND ct.cuisine_name = 'Chinese';

-- Beverages
INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
SELECT r.restaurant_id, mc.category_id, ct.cuisine_id, 'Jasmine Tea', 'Traditional Chinese jasmine tea', 'jasmine_tea.jpg', 60.00, 1, GETDATE()
FROM restaurants r, menu_categories mc, cuisine_types ct
WHERE r.name = 'Yum Cha' AND mc.category_name = 'Beverages' AND ct.cuisine_name = 'Chinese';

INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
SELECT r.restaurant_id, mc.category_id, ct.cuisine_id, 'Oolong Tea', 'Semi-oxidized Chinese tea with floral notes', 'oolong_tea.jpg', 70.00, 1, GETDATE()
FROM restaurants r, menu_categories mc, cuisine_types ct
WHERE r.name = 'Yum Cha' AND mc.category_name = 'Beverages' AND ct.cuisine_name = 'Chinese';

INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
SELECT r.restaurant_id, mc.category_id, ct.cuisine_id, 'Winter Melon Tea', 'Refreshing tea made from winter melon', 'melon_tea.jpg', 80.00, 1, GETDATE()
FROM restaurants r, menu_categories mc, cuisine_types ct
WHERE r.name = 'Yum Cha' AND mc.category_name = 'Beverages' AND ct.cuisine_name = 'Chinese';

INSERT INTO menu_items (restaurant_id, category_id, cuisine_id, item_name, description, item_image, price, is_available, created_at)
SELECT r.restaurant_id, mc.category_id, ct.cuisine_id, 'Soy Milk', 'Fresh homemade soy milk', 'soy_milk.jpg', 50.00, 1, GETDATE()
FROM restaurants r, menu_categories mc, cuisine_types ct
WHERE r.name = 'Yum Cha' AND mc.category_name = 'Beverages' AND ct.cuisine_name = 'Chinese';

GO

-- Verify inserted items
SELECT 'YUM CHA ITEMS' AS Restaurant, mc.category_name, mi.item_name, mi.price, mi.is_available
FROM menu_items mi
JOIN restaurants r ON mi.restaurant_id = r.restaurant_id
JOIN menu_categories mc ON mi.category_id = mc.category_id
WHERE r.name = 'Yum Cha'
ORDER BY mc.display_order, mi.item_name;
