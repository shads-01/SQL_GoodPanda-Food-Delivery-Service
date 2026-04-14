SELECT menu_items.*, menu_categories.category_name
FROM menu_items
LEFT JOIN menu_categories ON menu_items.category_id = menu_categories.category_id
WHERE menu_items.item_id = ?
  AND menu_items.restaurant_id = ?
