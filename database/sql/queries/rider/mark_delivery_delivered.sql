-- Params: delivery_id, partner_id, order_id, order_id, partner_id
BEGIN TRANSACTION;

UPDATE deliveries 
SET delivery_status = 'delivered', delivered_time = GETDATE() 
WHERE delivery_id = ? AND partner_id = ?;

UPDATE orders 
SET order_status = 'delivered' 
WHERE order_id = ?;

UPDATE delivery_partner_profiles 
SET total_earnings = total_earnings + ISNULL((SELECT delivery_fee FROM orders WHERE order_id = ?), 0) 
WHERE partner_id = ?;

COMMIT TRANSACTION;
