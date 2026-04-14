-- Param: partner_id
SELECT TOP 1
    d.delivery_id,
    d.delivery_status,
    d.order_id,
    o.order_status,
    o.total_amount,
    r.name AS restaurant_name,
    r.location AS restaurant_address,
    ca.address_line,
    ca.city
FROM deliveries d
INNER JOIN orders o ON d.order_id = o.order_id
INNER JOIN restaurants r ON o.restaurant_id = r.restaurant_id
LEFT JOIN customer_addresses ca ON o.delivery_address_id = ca.address_id
WHERE d.partner_id = ? 
  AND d.delivery_status IN ('assigned', 'picked_up', 'on_the_way')
ORDER BY d.delivery_id DESC
