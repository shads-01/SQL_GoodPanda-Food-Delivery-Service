-- Params: delivery_id, partner_id, order_id
UPDATE deliveries 
SET delivery_status = 'picked_up', pickup_time = GETDATE() 
WHERE delivery_id = ? AND partner_id = ?;

UPDATE orders 
SET order_status = 'on_the_way' 
WHERE order_id = ?;
