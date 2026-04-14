INSERT INTO offers (
    restaurant_id, 
    offer_title, 
    discount_type, 
    discount_value, 
    target_type, 
    target_item_id, 
    target_category_id, 
    min_order_amount, 
    start_datetime, 
    end_datetime, 
    is_active, 
    created_at
)
VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, GETDATE() );
