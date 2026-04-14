-- TOP SELLING ITEMS
-- Aggregate: SUM, GROUP BY, ORDER BY
-- Shows top 5 items by quantity sold from delivered orders
SELECT TOP 5
    mi.item_name,
    mi.item_image,
    SUM(ci.quantity) AS total_quantity_sold,
    SUM(ci.quantity * ci.unit_price) AS total_revenue_from_item
FROM menu_items mi
INNER JOIN cart_items ci ON mi.item_id = ci.item_id
INNER JOIN orders o ON ci.cart_id = o.cart_id
WHERE mi.restaurant_id = ?
  AND o.order_status = 'delivered'
GROUP BY
    mi.item_id,
    mi.item_name,
    mi.item_image
ORDER BY
    total_quantity_sold DESC;
