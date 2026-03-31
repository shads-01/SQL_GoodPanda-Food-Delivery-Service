IF NOT EXISTS (SELECT name FROM sys.databases WHERE name = 'goodpanda_db')
    CREATE DATABASE goodpanda_db;
USE goodpanda_db;

--  Drop table codes
--  DROP TABLE IF EXISTS reviews, deliveries, delivery_partners, payments, order_details, orders, cart_items, cart, offers, menu_items, menu_categories, restaurant_ratings, restaurant_cuisines, restaurants, cuisine_types, customer_addresses, users, failed_jobs, job_batches, jobs, cache_locks, cache;

-- 0. LARAVEL INTERNALS
-- CACHE TABLES
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'cache') AND type = 'U')
BEGIN
    CREATE TABLE cache (
        [key] VARCHAR(255) NOT NULL PRIMARY KEY,
        value VARCHAR(MAX) NOT NULL,
        expiration INT NOT NULL
    );

    CREATE INDEX idx_cache_expiration ON cache(expiration);

    CREATE TABLE cache_locks (
        [key] VARCHAR(255) NOT NULL PRIMARY KEY,
        owner VARCHAR(255) NOT NULL,
        expiration INT NOT NULL
    );

    CREATE INDEX idx_cache_locks_expiration ON cache_locks(expiration);
END


-- JOBS TABLE
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'jobs') AND type = 'U')
BEGIN
    CREATE TABLE jobs (
        id BIGINT IDENTITY(1,1) PRIMARY KEY,
        queue VARCHAR(255) NOT NULL,
        payload VARCHAR(MAX) NOT NULL,
        attempts TINYINT NOT NULL,
        reserved_at INT NULL,
        available_at INT NOT NULL,
        created_at INT NOT NULL
    );

    CREATE INDEX idx_jobs_queue ON jobs(queue);
END


-- JOB BATCHES
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'job_batches') AND type = 'U')
BEGIN
    CREATE TABLE job_batches (
        id VARCHAR(255) PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        total_jobs INT NOT NULL,
        pending_jobs INT NOT NULL,
        failed_jobs INT NOT NULL,
        failed_job_ids VARCHAR(MAX) NOT NULL,
        options VARCHAR(MAX) NULL,
        cancelled_at INT NULL,
        created_at INT NOT NULL,
        finished_at INT NULL
    );
END


-- FAILED JOBS
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'failed_jobs') AND type = 'U')
BEGIN
    CREATE TABLE failed_jobs (
        id BIGINT IDENTITY(1,1) PRIMARY KEY,
        uuid VARCHAR(255) NOT NULL UNIQUE,
        connection VARCHAR(MAX) NOT NULL,
        queue VARCHAR(MAX) NOT NULL,
        payload VARCHAR(MAX) NOT NULL,
        exception VARCHAR(MAX) NOT NULL,
        failed_at DATETIME DEFAULT GETDATE()
    );
END

-- 1. USERS (Core Auth)
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'users') AND type = 'U')
BEGIN
    CREATE TABLE users (
        id BIGINT IDENTITY(1,1) PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        phone_number VARCHAR(20) NOT NULL UNIQUE,
        email_verified_at DATETIME NULL,
        password VARCHAR(255) NOT NULL,
        remember_token VARCHAR(100) NULL,
        profile_image VARCHAR(500) NULL,
        is_active TINYINT NOT NULL DEFAULT 1,
        created_at DATETIME NULL,
        updated_at DATETIME NULL
    );
END

-- 2. CUSTOMER ADDRESSES
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'customer_addresses') AND type = 'U')
BEGIN
    CREATE TABLE customer_addresses (
        address_id BIGINT IDENTITY(1,1) PRIMARY KEY,
        customer_id BIGINT NOT NULL FOREIGN KEY REFERENCES users(id),
        label VARCHAR(50) NOT NULL, -- Home, Office, etc.
        address_line VARCHAR(255) NOT NULL,
        city VARCHAR(100) NOT NULL,
        is_default TINYINT NOT NULL DEFAULT 0
    );
END

-- 3. CUISINE TYPES
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'cuisine_types') AND type = 'U')
BEGIN
    CREATE TABLE cuisine_types (
        cuisine_id INT IDENTITY(1,1) PRIMARY KEY,
        cuisine_name VARCHAR(100) NOT NULL UNIQUE,
        description VARCHAR(255) NULL
    );
END

-- 4. RESTAURANTS
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'restaurants') AND type = 'U')
BEGIN
    CREATE TABLE restaurants (
        restaurant_id INT IDENTITY(1,1) PRIMARY KEY,
        owner_id BIGINT NULL FOREIGN KEY REFERENCES users(id),
        name VARCHAR(255) NOT NULL,
        location VARCHAR(255) NOT NULL,
        phone_number VARCHAR(20) NOT NULL UNIQUE,
        profile_image VARCHAR(500) NOT NULL,
        cover_image VARCHAR(500) NULL,
        open_status TINYINT NOT NULL DEFAULT 1,
        created_at DATETIME NULL,
        updated_at DATETIME NULL
    );
END

-- 5. RESTAURANT CUISINES (M:N Junction)
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'restaurant_cuisines') AND type = 'U')
BEGIN
    CREATE TABLE restaurant_cuisines (
        restaurant_id INT NOT NULL FOREIGN KEY REFERENCES restaurants(restaurant_id),
        cuisine_id INT NOT NULL FOREIGN KEY REFERENCES cuisine_types(cuisine_id),
        PRIMARY KEY (restaurant_id, cuisine_id)
    );
END

-- 6. RESTAURANT RATINGS (Aggregated)
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'restaurant_ratings') AND type = 'U')
BEGIN
    CREATE TABLE restaurant_ratings (
        rating_id INT IDENTITY(1,1) PRIMARY KEY,
        restaurant_id INT NOT NULL UNIQUE FOREIGN KEY REFERENCES restaurants(restaurant_id),
        avg_rating DECIMAL(3,2) NOT NULL DEFAULT 0.00,
        total_reviews INT NOT NULL DEFAULT 0,
        last_updated DATETIME NOT NULL DEFAULT GETDATE()
    );
END

-- 7. MENU CATEGORIES
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'menu_categories') AND type = 'U')
BEGIN
    CREATE TABLE menu_categories (
        category_id INT IDENTITY(1,1) PRIMARY KEY,
        restaurant_id INT NOT NULL FOREIGN KEY REFERENCES restaurants(restaurant_id),
        category_name VARCHAR(100) NOT NULL,
        display_order INT NOT NULL DEFAULT 0
    );
END

-- 8. MENU ITEMS
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'menu_items') AND type = 'U')
BEGIN
    CREATE TABLE menu_items (
        item_id INT IDENTITY(1,1) PRIMARY KEY,
        restaurant_id INT NOT NULL FOREIGN KEY REFERENCES restaurants(restaurant_id),
        category_id INT NULL FOREIGN KEY REFERENCES menu_categories(category_id),
        cuisine_id INT NULL FOREIGN KEY REFERENCES cuisine_types(cuisine_id),
        item_name VARCHAR(100) NOT NULL,
        description VARCHAR(255) NULL,
        item_image VARCHAR(500) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        is_available TINYINT NOT NULL DEFAULT 1,
        created_at DATETIME NULL,
        updated_at DATETIME NULL
    );
END

-- 9. OFFERS
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'offers') AND type = 'U')
BEGIN
    CREATE TABLE offers (
        offer_id INT IDENTITY(1,1) PRIMARY KEY,
        restaurant_id INT NOT NULL FOREIGN KEY REFERENCES restaurants(restaurant_id),
        offer_title VARCHAR(150) NOT NULL,
        discount_type VARCHAR(20) NOT NULL CHECK (discount_type IN ('percentage', 'flat', 'free_delivery')),
        discount_value DECIMAL(8,2) NULL,
        target_type VARCHAR(20) NOT NULL CHECK (target_type IN ('item', 'category', 'restaurant')),
        target_item_id INT NULL FOREIGN KEY REFERENCES menu_items(item_id),
        target_category_id INT NULL FOREIGN KEY REFERENCES menu_categories(category_id),
        min_order_amount DECIMAL(10,2) NULL,
        start_datetime DATETIME NOT NULL,
        end_datetime DATETIME NOT NULL,
        is_active TINYINT NOT NULL DEFAULT 1,
        created_at DATETIME NULL
    );
END

-- 10. CART
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'cart') AND type = 'U')
BEGIN
    CREATE TABLE cart (
        cart_id INT IDENTITY(1,1) PRIMARY KEY,
        customer_id BIGINT NOT NULL FOREIGN KEY REFERENCES users(id),
        restaurant_id INT NOT NULL FOREIGN KEY REFERENCES restaurants(restaurant_id),
        created_at DATETIME NOT NULL DEFAULT GETDATE(),
        status VARCHAR(25) NOT NULL CHECK (status IN('active', 'converted_to_order', 'abandoned')) DEFAULT 'active'
    );
END

-- 11. CART ITEMS
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'cart_items') AND type = 'U')
BEGIN
    CREATE TABLE cart_items (
        cart_item_id INT IDENTITY(1,1) PRIMARY KEY,
        cart_id INT NOT NULL FOREIGN KEY REFERENCES cart(cart_id),
        item_id INT NOT NULL FOREIGN KEY REFERENCES menu_items(item_id),
        quantity INT NOT NULL CHECK (quantity >= 1),
        unit_price DECIMAL(10,2) NOT NULL
    );
END

-- 12. ORDERS
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'orders') AND type = 'U')
BEGIN
    CREATE TABLE orders (
        order_id INT IDENTITY(1,1) PRIMARY KEY,
        customer_id BIGINT NOT NULL FOREIGN KEY REFERENCES users(id),
        restaurant_id INT NOT NULL FOREIGN KEY REFERENCES restaurants(restaurant_id),
        cart_id INT NULL FOREIGN KEY REFERENCES cart(cart_id),
        delivery_address_id BIGINT NULL FOREIGN KEY REFERENCES customer_addresses(address_id),
        offer_id INT NULL FOREIGN KEY REFERENCES offers(offer_id),
        order_datetime DATETIME NOT NULL DEFAULT GETDATE(),
        order_status VARCHAR(50) NOT NULL CHECK (order_status IN('pending','confirmed','preparing','ready','on_the_way','delivered','cancelled')),
        subtotal DECIMAL(10,2) NOT NULL,
        discount_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        delivery_fee DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        total_amount DECIMAL(10,2) NOT NULL
    );
END

-- 13. ORDER DETAILS
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'order_details') AND type = 'U')
BEGIN
    CREATE TABLE order_details (
        order_detail_id INT IDENTITY(1,1) PRIMARY KEY,
        order_id INT NOT NULL FOREIGN KEY REFERENCES orders(order_id),
        item_id INT NOT NULL FOREIGN KEY REFERENCES menu_items(item_id),
        quantity INT NOT NULL CHECK (quantity >= 1),
        unit_price_at_order DECIMAL(10,2) NOT NULL,
        line_total DECIMAL(10,2) NOT NULL
    );
END

-- 14. PAYMENTS
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'payments') AND type = 'U')
BEGIN
    CREATE TABLE payments (
        payment_id INT IDENTITY(1,1) PRIMARY KEY,
        order_id INT NOT NULL UNIQUE FOREIGN KEY REFERENCES orders(order_id),
        customer_id BIGINT NOT NULL FOREIGN KEY REFERENCES users(id),
        payment_method VARCHAR(50) NOT NULL CHECK (payment_method IN('cash' , 'card' , 'bkash' , 'nagad' , 'credit')), -- cash, bkash, nagad, etc.
        payment_status VARCHAR(50) NOT NULL CHECK (payment_status IN('pending' , 'paid' , 'failed' , 'refunded')),
        amount_paid DECIMAL(10,2) NOT NULL,
        payment_datetime DATETIME NOT NULL DEFAULT GETDATE(),
        transaction_ref VARCHAR(100) NULL UNIQUE
    );
END

-- 15. DELIVERY PARTNERS
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'delivery_partners') AND type = 'U')
BEGIN
    CREATE TABLE delivery_partners (
        partner_id INT IDENTITY(1,1) PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        phone_number VARCHAR(20) NOT NULL UNIQUE,
        vehicle_type VARCHAR(50) NOT NULL,
        is_available TINYINT NOT NULL DEFAULT 1,
        current_location VARCHAR(255) NULL,
        avg_rating DECIMAL(3,2) NOT NULL DEFAULT 0.00
    );
END

-- 16. DELIVERIES
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'deliveries') AND type = 'U')
BEGIN
    CREATE TABLE deliveries (
        delivery_id INT IDENTITY(1,1) PRIMARY KEY,
        order_id INT NOT NULL UNIQUE FOREIGN KEY REFERENCES orders(order_id),
        partner_id INT NULL FOREIGN KEY REFERENCES delivery_partners(partner_id),
        delivery_address_id BIGINT NULL FOREIGN KEY REFERENCES customer_addresses(address_id),
        pickup_time DATETIME NULL,
        delivered_time DATETIME NULL,
        estimated_arrival DATETIME NULL,
        delivery_status VARCHAR(50) NOT NULL CHECK(delivery_status IN('assigned','picked_up','on_the_way','delivered','failed'))
        )
END

-- 17. REVIEWS
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'reviews') AND type = 'U')
BEGIN
    CREATE TABLE reviews (
        review_id INT IDENTITY(1,1) PRIMARY KEY,
        order_id INT NOT NULL UNIQUE FOREIGN KEY REFERENCES orders(order_id),
        customer_id BIGINT NOT NULL FOREIGN KEY REFERENCES users(id),
        restaurant_id INT NOT NULL FOREIGN KEY REFERENCES restaurants(restaurant_id),
        partner_id INT NULL FOREIGN KEY REFERENCES delivery_partners(partner_id),
        restaurant_rating TINYINT NOT NULL CHECK (restaurant_rating BETWEEN 1 AND 5),
        delivery_rating TINYINT NULL CHECK (delivery_rating BETWEEN 1 AND 5),
        comment VARCHAR(500) NULL,
        review_datetime DATETIME NOT NULL DEFAULT GETDATE()
    );
END