-- Fetches top 3 restaurants by average rating (uses aggregate + subquery)
SELECT TOP 3
    r.restaurant_id,
    r.name,
    r.location,
    r.cover_image,
    rr.avg_rating,
    rr.total_reviews
FROM restaurants r
INNER JOIN restaurant_ratings rr ON r.restaurant_id = rr.restaurant_id
WHERE r.restaurant_id IN (
    SELECT restaurant_id FROM restaurant_ratings WHERE total_reviews > 0
)
ORDER BY rr.avg_rating DESC, rr.total_reviews DESC;