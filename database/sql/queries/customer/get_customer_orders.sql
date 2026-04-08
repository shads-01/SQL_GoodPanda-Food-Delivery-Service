-- Orders for a customer with restaurant name (for order history)
-- Param 1: customer_id
SELECT
    o.order_id,
    o.order_status,
    o.subtotal,
    o.discount_amount,
    o.delivery_fee,
    o.total_amount,
    o.order_datetime,
    r.name AS restaurant_name
FROM orders o
INNER JOIN restaurants r ON o.restaurant_id = r.restaurant_id
WHERE o.customer_id = ?
ORDER BY o.order_datetime DESC