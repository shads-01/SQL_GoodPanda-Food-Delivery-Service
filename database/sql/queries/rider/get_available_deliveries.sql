-- No explicit params needed, handled by manual pagination logic
SELECT 
    o.order_id,
    o.order_datetime,
    o.total_amount,
    r.name AS restaurant_name,
    r.location AS restaurant_address,
    ca.address_line,
    ca.city,
    ISNULL(ca.label, 'Delivery') AS address_label
FROM orders o
INNER JOIN restaurants r ON o.restaurant_id = r.restaurant_id
LEFT JOIN customer_addresses ca ON o.delivery_address_id = ca.address_id
WHERE o.order_status IN ('accepted', 'preparing', 'ready')
  AND o.order_id NOT IN (SELECT order_id FROM deliveries)
ORDER BY o.order_datetime ASC
