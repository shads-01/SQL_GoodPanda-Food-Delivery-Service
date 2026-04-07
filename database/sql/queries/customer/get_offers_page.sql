-- Fetches all active offer items, optionally filtered by cuisine_id list
-- Used for the offers page (grouped by restaurant in PHP)
SELECT
    mi.item_id,
    mi.item_name,
    mi.item_image,
    mi.description,
    mi.price,
    ROUND(mi.price - (mi.price * o.discount_value / 100), 2) AS offer_price,
    o.discount_value,
    mi.cuisine_id,
    ct.cuisine_name AS cuisine_names,
    r.restaurant_id,
    r.name AS restaurant_name,
    r.cover_image
FROM menu_items mi
INNER JOIN offers o ON o.target_item_id = mi.item_id
    AND o.is_active = 1
    AND o.target_type = 'item'
    AND GETDATE() BETWEEN o.start_datetime AND o.end_datetime
INNER JOIN restaurants r ON mi.restaurant_id = r.restaurant_id
LEFT JOIN cuisine_types ct ON mi.cuisine_id = ct.cuisine_id
WHERE mi.is_available = 1
ORDER BY r.restaurant_id, mi.item_name;