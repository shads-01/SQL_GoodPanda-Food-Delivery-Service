BEGIN TRANSACTION;

INSERT INTO deliveries (order_id, partner_id, delivery_address_id, delivery_status)
SELECT order_id, ?, delivery_address_id, 'assigned'
FROM orders o
WHERE order_id = ? 
  AND NOT EXISTS (SELECT 1 FROM deliveries d WHERE d.order_id = o.order_id);

IF @@ROWCOUNT > 0
BEGIN
    UPDATE orders SET order_status = 'confirmed' WHERE order_id = ?;
END

COMMIT TRANSACTION;
