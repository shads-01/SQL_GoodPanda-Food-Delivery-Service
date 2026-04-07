USE goodpanda_db;
GO

-- ============================================================
-- TRIGGER: trg_AfterAccountDeactivation
-- Fires AFTER UPDATE on users when is_active changes to 0.
-- Logs the deactivation event for audit (using a simple log table).
-- Demonstrates AFTER UPDATE trigger with conditional logic.
-- ============================================================

-- First, create the audit log table if it doesn't exist
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'account_deletion_log') AND type = 'U')
BEGIN
    CREATE TABLE account_deletion_log (
        log_id      BIGINT IDENTITY(1,1) PRIMARY KEY,
        user_id     BIGINT NOT NULL,
        user_email  VARCHAR(100),
        deleted_at  DATETIME DEFAULT GETDATE(),
        action_type VARCHAR(50) DEFAULT 'soft_delete'
    );
END
GO

-- Drop trigger if exists so we can recreate cleanly
IF OBJECT_ID('trg_AfterAccountDeactivation', 'TR') IS NOT NULL
    DROP TRIGGER trg_AfterAccountDeactivation;
GO

CREATE TRIGGER trg_AfterAccountDeactivation
ON users
AFTER UPDATE
AS
BEGIN
    SET NOCOUNT ON;

    -- Only fire when is_active changed from 1 → 0
    IF UPDATE(is_active)
    BEGIN
        INSERT INTO account_deletion_log (user_id, user_email, deleted_at, action_type)
        SELECT
            i.id,
            i.email,
            GETDATE(),
            'soft_delete'
        FROM inserted i
        INNER JOIN deleted d ON i.id = d.id
        WHERE i.is_active = 0
          AND d.is_active = 1;
    END
END;
GO

-- Verify trigger was created
SELECT name, type_desc, create_date
FROM sys.triggers
WHERE name = 'trg_AfterAccountDeactivation';
GO