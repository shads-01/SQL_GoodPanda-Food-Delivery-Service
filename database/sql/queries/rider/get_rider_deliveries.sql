-- Param 1: partner_id
SELECT 
    d.delivery_id, 
    d.delivery_status, 
    d.pickup_time, 
    d.delivered_time,
    o.order_id,
    o.total_amount,
    r.name AS restaurant_name,
    c.address_line,
    c.city
FROM deliveries d
INNER JOIN orders o ON d.order_id = o.order_id
INNER JOIN restaurants r ON o.restaurant_id = r.restaurant_id
LEFT JOIN customer_addresses c ON o.delivery_address_id = c.address_id
WHERE d.partner_id = ?
ORDER BY d.delivery_id DESC
