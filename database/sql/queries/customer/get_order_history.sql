SELECT 
    o.*, 
    r.name as restaurant_name, 
    d.partner_id,
    rev.review_id
FROM orders o
JOIN restaurants r ON o.restaurant_id = r.restaurant_id
LEFT JOIN deliveries d ON o.order_id = d.order_id
LEFT JOIN reviews rev ON o.order_id = rev.order_id
WHERE o.customer_id = ?
ORDER BY o.order_datetime DESC;
