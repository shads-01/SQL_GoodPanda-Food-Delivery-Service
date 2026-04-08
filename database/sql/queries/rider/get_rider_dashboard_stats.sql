-- Params: partner_id, partner_id
SELECT 
    dp.total_earnings,
    (SELECT COUNT(*) FROM deliveries d WHERE d.partner_id = ? AND d.delivery_status = 'delivered') AS total_deliveries
FROM delivery_partner_profiles dp
WHERE dp.partner_id = ?
