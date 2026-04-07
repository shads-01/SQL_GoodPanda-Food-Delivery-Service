-- Set an address as default (clears others first) — two statements
UPDATE customer_addresses
SET is_default = 0
WHERE customer_id = @customerId;

UPDATE customer_addresses
SET is_default = 1
WHERE address_id  = @addressId
  AND customer_id = @customerId;