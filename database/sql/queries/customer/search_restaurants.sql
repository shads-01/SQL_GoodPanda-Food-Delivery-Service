-- Search restaurants by name with popularity score
-- Param 1: search term (pass as '%term%' from PHP)
SELECT
    r.restaurant_id,
    r.name,
    r.location,
    r.cover_image,
    ISNULL(rr.avg_rating, 0) AS avg_rating,
    ISNULL(rr.total_reviews, 0) AS total_reviews,
    (SELECT COUNT(*) FROM orders o WHERE o.restaurant_id = r.restaurant_id) AS order_count
FROM restaurants r
LEFT JOIN restaurant_ratings rr ON r.restaurant_id = rr.restaurant_id
WHERE r.name LIKE ?
ORDER BY order_count DESC, avg_rating DESC