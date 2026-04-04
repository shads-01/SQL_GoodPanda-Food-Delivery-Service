INSERT INTO restaurants (owner_id, name, location, phone_number, profile_image, cover_image, open_status, created_at)
OUTPUT INSERTED.owner_id
VALUES (?, ?, ?, ?, ?, ?, ?, GETDATE());
