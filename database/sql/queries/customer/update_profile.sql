-- Update customer name, email, phone
UPDATE users
SET
    name         = :name,
    email        = :email,
    phone_number = :phone
WHERE id = :userId
  AND is_active = 1;