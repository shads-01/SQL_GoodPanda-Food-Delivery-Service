UPDATE offers 
SET is_active = CASE WHEN is_active = 1 THEN 0 ELSE 1 END 
WHERE offer_id = ? AND restaurant_id = ?
