-- Mark account as inactive (soft delete)
UPDATE users
SET is_active = 0
WHERE id = @userId;