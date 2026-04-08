USE goodpanda_db;
GO

CREATE OR ALTER PROCEDURE sp_get_restaurant_by_id
    @restaurant_id INT
AS
BEGIN   
    SELECT r.restaurant_id, r.name, r.location, r.phone_number, r.cover_image, r.open_status, ISNULL(rr.avg_rating, 0) AS avg_rating, ISNULL(rr.total_reviews, 0) AS total_reviews
    FROM restaurants r LEFT JOIN restaurant_ratings rr
    ON r.restaurant_id = rr.restaurant_id
    WHERE r.restaurant_id = @restaurant_id;
END;
GO

CREATE OR ALTER PROCEDURE sp_get_restaurant_items
    @restaurant_id INT
AS
BEGIN
    SELECT mi.item_id, mi.item_name, mi.description, mi.item_image, mi.price, mi.is_available, mc.category_name
    FROM menu_items mi LEFT JOIN menu_categories mc
    ON mi.category_id = mc.category_id
    WHERE mi.restaurant_id = @restaurant_id
        AND mi.is_available = 1
    ORDER BY mc.display_order, mi.item_name;
END;
GO

-- Restaurant specific categories
CREATE OR ALTER PROCEDURE sp_get_categories_by_restaurant
    @restaurant_id INT
AS
BEGIN
    SELECT category_id, category_name 
    FROM menu_categories 
    WHERE restaurant_id = @restaurant_id
    ORDER BY display_order;
END;
GO

-- Items searching and filtering
CREATE OR ALTER PROCEDURE sp_search_menu_items
    @restaurant_id INT,
    @category_id INT = NULL,
    @search_term VARCHAR(100) = NULL,
    @cuisine_id INT = NULL
AS
BEGIN
    SET NOCOUNT ON;
    SELECT mi.*, c.category_name, ct.cuisine_name
    FROM menu_items mi 
    LEFT JOIN menu_categories c ON mi.category_id = c.category_id
    LEFT JOIN cuisine_types ct ON mi.cuisine_id = ct.cuisine_id
    WHERE mi.restaurant_id = @restaurant_id
        AND (@search_term IS NULL OR mi.item_name LIKE '%' + @search_term + '%')
        AND (@category_id IS NULL OR mi.category_id = @category_id)
        AND (@cuisine_id IS NULL OR mi.cuisine_id = @cuisine_id);
END;
GO

-- Restaurant specific cuisines
CREATE OR ALTER PROCEDURE sp_get_cuisines_by_restaurant
    @restaurant_id INT
AS
BEGIN
    SELECT DISTINCT ct.cuisine_id, ct.cuisine_name
    FROM restaurant_cuisines rc
    JOIN cuisine_types ct ON rc.cuisine_id = ct.cuisine_id
    WHERE rc.restaurant_id = @restaurant_id
    ORDER BY ct.cuisine_name;
END;
GO