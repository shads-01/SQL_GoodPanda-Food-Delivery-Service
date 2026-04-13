-- Get the 3 most recent orders for a customer (profile summary)
-- Param 1: customer_id
SELECT TOP 3
    o.*,
    r.name AS restaurant_name,
    d.partner_id,
    u_p.name AS partner_name,
    rv.review_id
FROM orders o
INNER JOIN restaurants r ON o.restaurant_id = r.restaurant_id
LEFT JOIN deliveries d ON o.order_id = d.order_id
LEFT JOIN users u_p ON d.partner_id = u_p.id
LEFT JOIN reviews rv ON o.order_id = rv.order_id
WHERE o.customer_id = ?
ORDER BY o.order_datetime DESC
