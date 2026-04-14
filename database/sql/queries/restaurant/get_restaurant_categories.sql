SELECT category_id, category_name 
FROM menu_categories 
WHERE restaurant_id = ?
ORDER BY category_name ASC
