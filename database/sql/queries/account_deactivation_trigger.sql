CREATE OR ALTER TRIGGER trg_AfterAccountDeactivation
ON users
AFTER UPDATE
AS
BEGIN
    SET NOCOUNT ON;
    
    -- When a user account is deleted (is_active updated to 0)
    -- We append identifying unique junk to their email and phone_number.
    -- This circumvents the UNIQUE constraints, so the user can sign up again
    -- using their old credentials as requested, while keeping foreign keys intact.
    
    IF UPDATE(is_active)
    BEGIN
        UPDATE u
        SET 
            u.email = 'deleted_' + CAST(u.id AS VARCHAR(20)) + '_' + u.email,
            -- Phone number CHECK constraint requires exactly '01' followed by 9 digits.
            -- Using their padded id preserves uniqueness securely without failing check constraints.
            u.phone_number = '010' + RIGHT('00000000' + CAST(u.id AS VARCHAR(8)), 8)
        FROM users u
        INNER JOIN inserted i ON u.id = i.id
        WHERE i.is_active = 0 AND u.email NOT LIKE 'deleted_%';
    END
END;
GO
