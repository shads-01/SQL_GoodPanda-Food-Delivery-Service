SELECT
    o.order_id,
    u.name as customer_name,
    (o.total_amount - o.delivery_fee) as total_amount,
    o.order_status,
    o.order_datetime,
    ca.address_line as delivery_address
FROM orders as o
JOIN users as u ON o.customer_id = u.id
LEFT JOIN customer_addresses as ca ON o.delivery_address_id = ca.address_id
WHERE o.restaurant_id = ?
  AND (
      ? = 'all'
      OR (? = 'pending' AND o.order_status IN ('pending', 'confirmed', 'preparing', 'ready', 'on_the_way'))
      OR (? = 'completed' AND o.order_status = 'delivered')
      OR (? = 'cancelled' AND o.order_status = 'cancelled')
  )
ORDER BY o.order_datetime DESC
