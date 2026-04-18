USE goodpanda_db;
GO

CREATE OR ALTER PROCEDURE sp_get_customer_addresses
    @customer_id BIGINT
AS
BEGIN
    SET NOCOUNT ON;
    
    SELECT address_id, label, address_line, city, is_default
    FROM customer_addresses
    WHERE customer_id = @customer_id
    ORDER BY is_default DESC, address_id ASC;
END;
