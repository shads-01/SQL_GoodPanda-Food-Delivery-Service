-- Delete an address for a customer
DELETE FROM customer_addresses
WHERE address_id  = :addressId
  AND customer_id = :customerId;