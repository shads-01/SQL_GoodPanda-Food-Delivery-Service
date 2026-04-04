INSERT INTO users (role, name, email, password, phone_number, is_active, created_at) 
OUTPUT INSERTED.id 
VALUES (?, ?, ?, ?, ?, ?, GETDATE());
