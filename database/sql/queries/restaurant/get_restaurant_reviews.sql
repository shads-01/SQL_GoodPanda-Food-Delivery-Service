SELECT rev.*, u.name as reviewer_name
FROM reviews as rev
JOIN users as u ON rev.customer_id = u.id
WHERE rev.restaurant_id = ?
ORDER BY rev.review_datetime DESC
