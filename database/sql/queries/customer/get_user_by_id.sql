-- Get a single user by ID
-- Param 1: user_id
SELECT * FROM users WHERE id = ? AND is_active = 1
