USE goodpanda_db;
GO

CREATE OR ALTER VIEW vw_customer_profile_by_id AS
SELECT * FROM users u
JOIN customer_addresses ca ON u.id = ca.customer_id;