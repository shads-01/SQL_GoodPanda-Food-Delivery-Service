CREATE OR ALTER PROCEDURE sp_remove_from_cart
    @customer_id BIGINT,
    @restaurant_id INT,
    @item_id INT
AS
BEGIN
    DECLARE @cart_id INT;

    SELECT @cart_id = cart_id FROM cart
    WHERE customer_id   = @customer_id AND restaurant_id = @restaurant_id AND status = 'active';

    IF @cart_id IS NOT NULL
    BEGIN
        DELETE FROM cart_items
        WHERE cart_id = @cart_id
          AND item_id = @item_id;
    END
END;
