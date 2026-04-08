INSERT INTO reviews (order_id, customer_id, restaurant_id, partner_id, restaurant_rating, delivery_rating, comment, review_datetime)
VALUES (?, ?, ?, ?, ?, ?, ?, GETDATE());