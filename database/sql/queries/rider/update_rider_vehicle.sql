-- Update vehicle details
-- Params: vehicle_type, is_available, partner_id
UPDATE delivery_partner_profiles
SET vehicle_type = ?, is_available = ?
WHERE partner_id = ?
