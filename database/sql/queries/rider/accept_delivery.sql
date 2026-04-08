-- Params: partner_id, order_id
INSERT INTO deliveries (order_id, partner_id, delivery_address_id, delivery_status)
SELECT order_id, ?, delivery_address_id, 'assigned'
FROM orders 
WHERE order_id = ?
