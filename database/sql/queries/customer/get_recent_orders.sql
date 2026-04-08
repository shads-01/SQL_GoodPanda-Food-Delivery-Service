-- Get the 3 most recent orders for a customer (profile summary)
-- Param 1: customer_id
SELECT TOP 3
    o.*,
    r.name AS restaurant_name
FROM orders o
INNER JOIN restaurants r ON o.restaurant_id = r.restaurant_id
WHERE o.customer_id = ?
ORDER BY o.order_datetime DESC
