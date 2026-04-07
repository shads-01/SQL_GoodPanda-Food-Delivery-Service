-- Search restaurants by name with popularity score
SELECT
    r.restaurant_id,
    r.name,
    r.location,
    r.cover_image,
    ISNULL(rr.avg_rating, 0) AS avg_rating,
    ISNULL(rr.total_reviews, 0) AS total_reviews,
    -- Popularity: total orders for this restaurant (aggregate subquery)
    (SELECT COUNT(*) FROM orders o WHERE o.restaurant_id = r.restaurant_id) AS order_count
FROM restaurants r
LEFT JOIN restaurant_ratings rr ON r.restaurant_id = rr.restaurant_id
WHERE r.name LIKE CONCAT('%', @q, '%')
ORDER BY order_count DESC, rr.avg_rating DESC;