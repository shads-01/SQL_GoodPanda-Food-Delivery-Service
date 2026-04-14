UPDATE offers
SET offer_title = ?,
    discount_type = ?,
    discount_value = ?,
    target_type = ?,
    target_item_id = ?,
    target_category_id = ?,
    min_order_amount = ?,
    start_datetime = ?,
    end_datetime = ?
WHERE offer_id = ? AND restaurant_id = ?
