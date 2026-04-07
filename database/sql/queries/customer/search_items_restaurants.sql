-- Search menu items by name with optional cuisine filter, offer filter, sort
-- Parameters: @q (search term), @offersOnly (0/1)
SELECT
    mi.item_id,
    mi.item_name,
    mi.item_image,
    mi.description,
    mi.price,
    CASE
        WHEN o.offer_id IS NOT NULL
        THEN ROUND(mi.price - (mi.price * o.discount_value / 100), 2)
        ELSE NULL
    END AS offer_price,
    ct.cuisine_name AS cuisine_names,
    ct.cuisine_id,
    r.name AS restaurant_name,
    -- Popularity: total times ordered (aggregate via subquery)
    (SELECT COUNT(*) FROM cart_items ci WHERE ci.item_id = mi.item_id) AS order_count
FROM menu_items mi
LEFT JOIN offers o ON o.target_item_id = mi.item_id
    AND o.is_active = 1
    AND o.target_type = 'item'
    AND GETDATE() BETWEEN o.start_datetime AND o.end_datetime
LEFT JOIN cuisine_types ct ON mi.cuisine_id = ct.cuisine_id
INNER JOIN restaurants r ON mi.restaurant_id = r.restaurant_id
WHERE mi.is_available = 1
  AND mi.item_name LIKE CONCAT('%', @q, '%')
  AND (@offersOnly = 0 OR o.offer_id IS NOT NULL);