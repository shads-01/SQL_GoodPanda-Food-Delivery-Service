-- ACTIVE / PENDING ORDERS
-- Uses IN clause to filter by active statuses
SELECT TOP 5
    o.order_id,
    u.name AS customer_name,
    o.order_datetime,
    (o.total_amount - o.delivery_fee) AS subtotal,
    o.order_status
FROM orders o
INNER JOIN users u ON o.customer_id = u.id
WHERE o.restaurant_id = ?
  AND o.order_status IN ('pending', 'confirmed', 'preparing', 'ready')
ORDER BY o.order_datetime ASC;
