UPDATE delivery_partner_profiles
SET avg_rating = (
    SELECT AVG(CAST(delivery_rating AS DECIMAL(3,2)))
    FROM reviews
    WHERE partner_id = ? AND delivery_rating IS NOT NULL
)
WHERE partner_id = ?;
