-- Fetches all active offer items for the offers page
-- No base params — cuisine filter and ORDER BY appended dynamically in PHP
SELECT
    mi.item_id,
    mi.item_name,
    mi.item_image,
    mi.description,
    mi.price,
    CASE 
        WHEN o.discount_type = 'percentage' THEN ROUND(mi.price - (mi.price * o.discount_value / 100), 2)
        WHEN o.discount_type = 'flat' THEN ROUND(mi.price - o.discount_value, 2)
        ELSE mi.price
    END AS offer_price,
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