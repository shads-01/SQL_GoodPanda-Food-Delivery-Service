-- RECENT ORDERS (All statuses, for the dashboard feed)
-- JOIN to get customer name
SELECT TOP 10
    o.order_id,
    u.name AS customer_name,
    (o.total_amount - o.delivery_fee) AS total_amount,
    o.order_status,
    o.order_datetime
FROM orders o
INNER JOIN users u ON o.customer_id = u.id
WHERE o.restaurant_id = ?
ORDER BY o.order_datetime DESC;
