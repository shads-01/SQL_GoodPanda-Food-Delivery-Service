-- Update basic user profile (name, email, phone)
-- Params: name, email, phone_number, user_id
UPDATE users
SET name = ?, email = ?, phone_number = ?
WHERE id = ? AND is_active = 1
