CREATE OR ALTER PROCEDURE sp_get_active_offers (
    @restaurant_id INT
)
AS
BEGIN
    SELECT o.offer_id,
        o.offer_title,
        o.discount_type,
        o.discount_value,
        o.target_type,
        o.target_item_id,
        o.target_category_id,
        o.min_order_amount,
        o.end_datetime,
        mi.item_name,
        mc.category_name
    FROM offers o LEFT JOIN menu_items mi ON o.target_item_id = mi.item_id AND o.target_type = 'item' LEFT JOIN menu_categories mc
    ON o.target_category_id = mc.category_id AND o.target_type = 'category'
    WHERE o.restaurant_id = @restaurant_id AND o.is_active = 1 AND GETDATE() BETWEEN o.start_datetime AND o.end_datetime
    ORDER BY o.created_at DESC;
END;
