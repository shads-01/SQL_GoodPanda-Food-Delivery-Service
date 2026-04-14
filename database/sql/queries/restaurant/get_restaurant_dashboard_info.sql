SELECT 
    r.*, 
    rr.avg_rating, 
    rr.total_reviews,
    (SELECT COUNT(*) FROM menu_items WHERE restaurant_id = r.restaurant_id) as total_items,
    (SELECT COUNT(*) FROM menu_items WHERE restaurant_id = r.restaurant_id AND is_available = 1) as available_items,
    (SELECT COUNT(*) FROM menu_items WHERE restaurant_id = r.restaurant_id AND is_available = 0) as unavailable_items
FROM restaurants r
LEFT JOIN restaurant_ratings rr ON r.restaurant_id = rr.restaurant_id
WHERE r.owner_id = ?
