-- Get all addresses for a customer, default address first
-- Param 1: customer_id
SELECT *
FROM customer_addresses
WHERE customer_id = ?
ORDER BY is_default DESC
