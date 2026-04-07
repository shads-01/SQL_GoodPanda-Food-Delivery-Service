CREATE OR ALTER PROCEDURE sp_view_cart
    @customer_id BIGINT,
    @restaurant_id INT
AS
BEGIN
    SELECT ci.item_id,
        mi.item_name,
        ci.unit_price,
        ci.quantity,
        mi.category_id,
        mi.item_image
    FROM cart c INNER JOIN cart_items ci ON c.cart_id = ci.cart_id
                INNER JOIN menu_items mi  ON ci.item_id = mi.item_id
    WHERE c.customer_id    = @customer_id AND c.restaurant_id  = @restaurant_id AND c.status = 'active';
END;
