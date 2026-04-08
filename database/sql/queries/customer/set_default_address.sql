-- Set an address as default (clears others first) — two statements
-- Executed within a DB transaction in PHP
UPDATE customer_addresses
SET is_default = 0
WHERE customer_id = ?;

UPDATE customer_addresses
SET is_default = 1
WHERE address_id  = ?
  AND customer_id = ?