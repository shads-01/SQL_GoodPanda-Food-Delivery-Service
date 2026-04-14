SELECT offers.*, menu_items.item_name, menu_categories.category_name
FROM offers
LEFT JOIN menu_items ON offers.target_item_id = menu_items.item_id
LEFT JOIN menu_categories ON offers.target_category_id = menu_categories.category_id
WHERE offers.restaurant_id = ?
ORDER BY offers.created_at DESC
