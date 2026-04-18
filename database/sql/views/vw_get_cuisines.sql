USE goodpanda_db;
GO

CREATE OR ALTER VIEW vw_get_cuisines AS 
SELECT * FROM cuisine_types;