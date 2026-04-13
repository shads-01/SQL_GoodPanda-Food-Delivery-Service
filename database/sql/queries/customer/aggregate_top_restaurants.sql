-- Aggregate Query for 3 Top Restaurants
SELECT TOP 3
    r.restaurant_id,
    r.name,
    r.location,
    r.cover_image,
    ISNULL(rr.avg_rating, 0) AS avg_rating,
    ISNULL(rr.total_reviews, 0) AS total_reviews,
    (SELECT COUNT(*) FROM orders o WHERE o.restaurant_id = r.restaurant_id) AS order_count
FROM restaurants r
LEFT JOIN restaurant_ratings rr ON r.restaurant_id = rr.restaurant_id
ORDER BY rr.avg_rating DESC, rr.total_reviews DESC, order_count DESC;
