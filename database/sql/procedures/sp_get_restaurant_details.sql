CREATE OR ALTER PROCEDURE sp_get_restaurant_by_id
    @restaurant_id INT
AS
BEGIN
    SET NOCOUNT ON;
    
    SELECT 
        r.restaurant_id, 
        r.name, 
        r.location, 
        r.phone_number, 
        r.profile_image, 
        r.cover_image, 
        r.open_status,
        ISNULL(rr.avg_rating, 0) AS avg_rating,
        ISNULL(rr.total_reviews, 0) AS total_reviews
    FROM restaurants r
    LEFT JOIN restaurant_ratings rr ON r.restaurant_id = rr.restaurant_id
    WHERE r.restaurant_id = @restaurant_id;
END;

/* SEP */

CREATE OR ALTER PROCEDURE sp_get_restaurant_items
    @restaurant_id INT
AS
BEGIN
    SET NOCOUNT ON;
    
    SELECT 
        mi.item_id,
        mi.item_name,
        mi.description,
        mi.item_image,
        mi.price,
        mi.is_available,
        mc.category_name
    FROM menu_items mi
    LEFT JOIN menu_categories mc ON mi.category_id = mc.category_id
    WHERE mi.restaurant_id = @restaurant_id
        AND mi.is_available = 1
    ORDER BY mc.display_order, mi.item_name;
END;
