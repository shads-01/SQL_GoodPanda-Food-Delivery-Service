CREATE OR ALTER PROCEDURE sp_place_order
    @customer_id BIGINT,
    @restaurant_id INT,
    @delivery_address_id BIGINT = NULL,
    @payment_method VARCHAR(50),
    @delivery_fee DECIMAL(10,2) = 70.00,
    @discount_amount DECIMAL(10,2) = 0.00,
    @offer_id INT = NULL
AS
BEGIN
    SET NOCOUNT ON;

    BEGIN TRY
        BEGIN TRANSACTION;

        DECLARE @cart_id INT;
        DECLARE @subtotal DECIMAL(10,2) = 0.00;
        DECLARE @total_amount DECIMAL(10,2) = 0.00;
        DECLARE @order_id INT;

        -- 1. Get active cart
        SELECT @cart_id = cart_id
        FROM cart
        WHERE customer_id = @customer_id AND restaurant_id = @restaurant_id AND status = 'active';

        IF @cart_id IS NULL
        BEGIN
            THROW 50001, 'No active cart found for this restaurant.', 1;
        END

        -- 2. Calculate subtotal
        SELECT @subtotal = ISNULL(SUM(quantity * unit_price), 0)
        FROM cart_items
        WHERE cart_id = @cart_id;

        IF @subtotal = 0
        BEGIN
            THROW 50002, 'Cart is empty.', 1;
        END

        SET @total_amount = @subtotal + @delivery_fee - @discount_amount;
        IF @total_amount < 0 SET @total_amount = 0;

        -- If address is not provided, pick default
        IF @delivery_address_id IS NULL OR @delivery_address_id = 0
        BEGIN
            SELECT TOP 1 @delivery_address_id = address_id
            FROM customer_addresses
            WHERE customer_id = @customer_id
            ORDER BY is_default DESC, address_id ASC;
        END

        -- 3. Create Order
        INSERT INTO orders (customer_id, restaurant_id, cart_id, delivery_address_id, offer_id, order_status, subtotal, discount_amount, delivery_fee, total_amount)
        VALUES (@customer_id, @restaurant_id, @cart_id, @delivery_address_id, @offer_id, 'pending', @subtotal, @discount_amount, @delivery_fee, @total_amount);

        SET @order_id = SCOPE_IDENTITY();

        -- 4. Update Cart status
        UPDATE cart
        SET status = 'converted_to_order'
        WHERE cart_id = @cart_id;

        -- 5. Insert Payment Details
        INSERT INTO payments (order_id, customer_id, payment_method, payment_status, amount_paid)
        VALUES (@order_id, @customer_id, @payment_method, 'paid', @total_amount);

        COMMIT TRANSACTION;

        SELECT @order_id AS order_id, 'Order placed successfully' AS message;

    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0
            ROLLBACK TRANSACTION;

        DECLARE @ErrorMsg NVARCHAR(4000) = ERROR_MESSAGE();
        RAISERROR(@ErrorMsg, 16, 1);
    END CATCH
END;
