-- Soft delete account: deactivate + mangle email & phone for UNIQUE constraint clearance
-- Param 1: user_id
UPDATE users
SET is_active    = 0,
    email        = CONCAT('deleted_', CAST(id AS VARCHAR), '_', email),
    phone_number = '010' + RIGHT('00000000' + CAST(id AS VARCHAR(8)), 8)
WHERE id = ?
  AND is_active = 1