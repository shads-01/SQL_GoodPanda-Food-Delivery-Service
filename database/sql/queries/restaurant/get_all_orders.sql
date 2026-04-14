SELECT 
    o.order_id,
    u.name AS customer_name,
    ca.address_line AS delivery_address,
    ca.address_line AS delivery_address_line,
    ca.city AS delivery_address_city,
    (o.total_amount - o.delivery_fee) AS total_amount,
    o.order_status,
    o.order_datetime,
    o.delivery_address_id
FROM orders o
INNER JOIN users u ON o.customer_id = u.id
LEFT JOIN customer_addresses ca ON o.delivery_address_id = ca.address_id
WHERE o.restaurant_id = ?
ORDER BY o.order_datetime DESC;
