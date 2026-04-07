INSERT INTO menu_categories (restaurant_id, category_name, display_order)
OUTPUT INSERTED.category_id
VALUES (?, ?, ?);
