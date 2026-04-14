SELECT item_id, item_name 
FROM menu_items 
WHERE restaurant_id = ?
ORDER BY item_name ASC
