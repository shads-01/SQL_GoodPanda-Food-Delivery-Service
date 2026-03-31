INSERT INTO restaurants (owner_id, name, location, phone_number, profile_image, cover_image, open_status, created_at, updated_at)
VALUES (?, ?, ?, ?, ?, ?, ?, GETDATE(), GETDATE());
