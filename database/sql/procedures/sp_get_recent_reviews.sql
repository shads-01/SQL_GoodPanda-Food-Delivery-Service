CREATE OR ALTER PROCEDURE sp_get_recent_reviews(
    @restaurant_id INT
)
AS
BEGIN
    SELECT TOP 10 
        rev.review_id, 
        u.name AS reviewer_name, 
        rev.restaurant_rating, 
        rev.delivery_rating, 
        rev.comment, 
        rev.review_datetime
    FROM reviews rev
    INNER JOIN users u ON rev.customer_id = u.id
    WHERE rev.restaurant_id = @restaurant_id
    ORDER BY rev.review_datetime DESC;
END