USE goodpanda_db;
GO

CREATE OR ALTER PROCEDURE sp_add_to_cart
    @customer_id BIGINT,
    @restaurant_id INT,
    @item_id INT,
    @quantity INT,
    @unit_price DECIMAL(10,2)
AS
BEGIN
    DECLARE @cart_id INT;

    SELECT @cart_id = cart_id FROM cart 
    WHERE customer_id = @customer_id AND restaurant_id = @restaurant_id AND status = 'active';

    -- If cart does not exist, create cart
    IF @cart_id IS NULL
    BEGIN
        INSERT INTO cart (customer_id, restaurant_id, status)
        VALUES (@customer_id, @restaurant_id, 'active');
        SET @cart_id = SCOPE_IDENTITY();
    END

    -- Check if item is already in cart
    IF EXISTS (SELECT 1 FROM cart_items WHERE cart_id = @cart_id AND item_id = @item_id)
    BEGIN
        UPDATE cart_items 
        SET quantity = quantity + @quantity
        WHERE cart_id = @cart_id AND item_id = @item_id;
    END
    ELSE
    BEGIN
        INSERT INTO cart_items (cart_id, item_id, quantity, unit_price)
        VALUES (@cart_id, @item_id, @quantity, @unit_price);
    END
END;
