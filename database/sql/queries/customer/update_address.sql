-- Update a customer address
UPDATE customer_addresses
SET
    label        = :label,
    address_line = :addressLine,
    city         = :city
WHERE address_id   = :addressId
  AND customer_id  = :customerId;
