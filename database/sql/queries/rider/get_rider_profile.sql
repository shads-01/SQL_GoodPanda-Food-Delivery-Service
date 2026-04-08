-- Param 1: user_id
SELECT 
    u.id, 
    u.name, 
    u.email, 
    u.phone_number, 
    u.created_at, 
    dp.vehicle_type, 
    dp.avg_rating, 
    dp.is_available
FROM users u
INNER JOIN delivery_partner_profiles dp ON u.id = dp.partner_id
WHERE u.id = ? AND u.is_active = 1
