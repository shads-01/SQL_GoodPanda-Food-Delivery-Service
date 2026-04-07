CREATE OR ALTER PROCEDURE sp_update_cart_quantity
    @customer_id BIGINT,
    @restaurant_id INT,
    @item_id INT,
    @qty_change INT
AS
BEGIN
    DECLARE @cart_id INT;

    SELECT @cart_id = cart_id FROM cart 
    WHERE customer_id = @customer_id AND restaurant_id = @restaurant_id AND status = 'active';

    IF @cart_id IS NOT NULL
    BEGIN
        DECLARE @current_qty INT;
        SELECT @current_qty = quantity FROM cart_items WHERE cart_id = @cart_id AND item_id = @item_id;

        IF @current_qty IS NOT NULL
        BEGIN
            IF (@current_qty + @qty_change) <= 0
            BEGIN
                -- If quantity hits 0 or below, Delete Item from Database completely
                DELETE FROM cart_items WHERE cart_id = @cart_id AND item_id = @item_id;
            END
            ELSE
            BEGIN
                UPDATE cart_items 
                SET quantity = quantity + @qty_change 
                WHERE cart_id = @cart_id AND item_id = @item_id;
            END
        END
    END
END;
