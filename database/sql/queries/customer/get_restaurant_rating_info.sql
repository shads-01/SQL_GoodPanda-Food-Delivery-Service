-- Fetch average rating and total review count for a specific restaurant
-- Param 1: restaurant_id
SELECT 
    restaurant_id,
    avg_rating,
    total_reviews
FROM restaurant_ratings
WHERE restaurant_id = ?;
