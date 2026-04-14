-- REVENUE & ORDER STATS
SELECT
    COUNT(order_id) AS total_completed_orders,
    SUM(total_amount - delivery_fee) AS total_revenue,
    (
        SELECT AVG(total_amount - delivery_fee)
        FROM orders
        WHERE restaurant_id = ? AND order_status = 'delivered'
    ) AS average_order_value
FROM orders
WHERE restaurant_id = ? AND order_status = 'delivered';
