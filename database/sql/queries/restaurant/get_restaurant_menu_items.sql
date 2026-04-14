SELECT menu_items.*, menu_categories.category_name
FROM menu_items
JOIN menu_categories ON menu_items.category_id = menu_categories.category_id
WHERE menu_items.restaurant_id = ?
ORDER BY menu_items.created_at DESC
