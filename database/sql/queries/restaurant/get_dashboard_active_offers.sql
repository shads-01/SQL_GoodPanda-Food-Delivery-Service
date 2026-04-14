SELECT o.*, mi.item_name
FROM offers o
LEFT JOIN menu_items mi ON o.target_item_id = mi.item_id
WHERE o.restaurant_id = ?
  AND o.is_active = 1
  AND o.start_datetime <= GETDATE()
  AND o.end_datetime >= GETDATE()
ORDER BY o.created_at DESC
