CREATE OR ALTER PROCEDURE sp_get_items_by_res_id
    @restaurant_id INT
AS
BEGIN
    SELECT menu_items.*, menu_categories.category_name, cuisine_types.cuisine_name
    FROM menu_items
    LEFT JOIN menu_categories ON menu_items.category_id = menu_categories.category_id
    LEFT JOIN cuisine_types ON menu_items.cuisine_id = cuisine_types.cuisine_id
    WHERE menu_items.restaurant_id = @restaurant_id
END;