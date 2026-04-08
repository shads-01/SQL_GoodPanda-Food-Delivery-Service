-- Soft delete rider account
-- Params: email, phone_number, user_id
UPDATE users
SET is_active = 0,
    email = ?,
    phone_number = ?
WHERE id = ?
