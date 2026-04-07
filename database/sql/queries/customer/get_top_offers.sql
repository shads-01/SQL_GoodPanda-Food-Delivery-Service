-- Fetch Top Offers using nested Sub Query filtering
SELECT TOP 6
    mi.item_id,
    mi.item_name,
    mi.item_image,
    mi.description,
    mi.price,
    o.offer_id,
    o.discount_value,
    o.discount_type,
    ROUND(mi.price - (mi.price * o.discount_value / 100), 2) AS offer_price,
    r.restaurant_id,
    r.name AS restaurant_name
FROM offers o
JOIN menu_items mi ON o.target_item_id = mi.item_id
JOIN restaurants r ON mi.restaurant_id = r.restaurant_id
WHERE o.is_active = 1 
  AND o.target_type = 'item'
  AND GETDATE() BETWEEN o.start_datetime AND o.end_datetime
  AND o.discount_value = (
      -- Sub Query Requirement Validation
      SELECT MAX(discount_value) 
      FROM offers o2 
      WHERE o2.target_item_id = mi.item_id 
        AND o2.is_active = 1
  )
ORDER BY (mi.price * o.discount_value / 100) DESC;