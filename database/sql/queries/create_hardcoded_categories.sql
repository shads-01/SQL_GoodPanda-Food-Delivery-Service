-- ============================================================
-- CREATE HARDCODED CATEGORIES WITH SPECIFIC IDs
-- ============================================================
USE goodpanda_db;
GO

-- Get your restaurant ID
DECLARE @restaurantId INT;
SELECT @restaurantId = restaurant_id FROM restaurants
WHERE owner_id = (SELECT id FROM users WHERE email = 'owner@gmail.com');

IF @restaurantId IS NOT NULL
BEGIN
    -- Delete any existing categories first
    DELETE FROM menu_categories WHERE restaurant_id = @restaurantId;

    -- Insert categories with specific IDs (1-4) to match hardcoded values
    SET IDENTITY_INSERT menu_categories ON;

    INSERT INTO menu_categories (category_id, restaurant_id, category_name, display_order)
    VALUES
        (1, @restaurantId, 'Main Course', 1),
        (2, @restaurantId, 'Appetizers', 2),
        (3, @restaurantId, 'Desserts', 3),
        (4, @restaurantId, 'Beverages', 4);

    SET IDENTITY_INSERT menu_categories OFF;

    PRINT 'Hardcoded categories created successfully!';
END
ELSE
BEGIN
    PRINT 'Restaurant not found for your user account!';
END

GO

-- Verify categories
SELECT 'CREATED CATEGORIES' AS status,
       mc.category_id,
       mc.category_name,
       mc.display_order,
       r.name AS restaurant_name
FROM menu_categories mc
JOIN restaurants r ON mc.restaurant_id = r.restaurant_id
WHERE r.owner_id = (SELECT id FROM users WHERE email = 'owner@gmail.com')
ORDER BY mc.category_id;

GO