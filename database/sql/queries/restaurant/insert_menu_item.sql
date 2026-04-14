INSERT INTO menu_items (
    restaurant_id,
    category_id,
    cuisine_id,
    item_name,
    description,
    item_image,
    price,
    is_available,
    created_at
) VALUES (?, ?, ?, ?, ?, ?, ?, 1, GETDATE())
