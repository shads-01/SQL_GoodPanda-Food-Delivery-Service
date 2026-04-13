-- Orders for a customer with restaurant name (for order history)
-- Param 1: customer_id
SELECT
    o.order_id,
    o.restaurant_id,
    o.order_status,
    o.subtotal,
    o.discount_amount,
    o.delivery_fee,
    o.total_amount,
    o.order_datetime,
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