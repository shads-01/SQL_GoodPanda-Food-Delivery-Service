-- RECENT REVIEWS & RATINGS
SELECT TOP 5
    rev.review_id,
    u.name AS reviewer_name,
    rev.restaurant_rating AS customer_rating,
    rev.comment,
    rev.review_datetime
FROM reviews rev
INNER JOIN users u ON rev.customer_id = u.id
WHERE rev.restaurant_id = ?
ORDER BY rev.review_datetime DESC;
