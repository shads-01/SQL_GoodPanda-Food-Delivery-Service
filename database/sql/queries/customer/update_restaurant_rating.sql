UPDATE restaurant_ratings
SET avg_rating = (
        SELECT AVG(CAST(restaurant_rating AS DECIMAL(3,2)))
        FROM reviews
        WHERE restaurant_id = ?
    ),
    total_reviews = (
        SELECT COUNT(*)
        FROM reviews
        WHERE restaurant_id = ?
    )
WHERE restaurant_id = ?;
