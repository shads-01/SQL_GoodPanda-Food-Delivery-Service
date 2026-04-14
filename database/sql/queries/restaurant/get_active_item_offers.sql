SELECT target_item_id, discount_type, discount_value, offer_title
FROM offers
WHERE restaurant_id = ?
  AND target_type = 'item'
  AND is_active = 1
  AND start_datetime <= GETDATE()
  AND end_datetime >= GETDATE()
