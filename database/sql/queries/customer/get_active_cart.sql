-- Get the active cart for a customer across all restaurants
-- Returns cart items joined with item and restaurant info
SELECT
    ci.item_id,
    mi.item_name,
    ci.unit_price,
    ci.quantity,
    mi.category_id,
    c.restaurant_id
FROM cart c
INNER JOIN cart_items ci ON c.cart_id = ci.cart_id
INNER JOIN menu_items mi ON ci.item_id = mi.item_id
WHERE c.customer_id = ?
  AND c.status = 'active'
