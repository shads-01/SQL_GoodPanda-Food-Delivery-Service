IF NOT EXISTS (SELECT name FROM sys.databases WHERE name = 'goodpanda_db')
    CREATE DATABASE goodpanda_db;
USE goodpanda_db;

-- ============================================================
-- 0. LARAVEL INTERNALS
-- ============================================================

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

-- ============================================================
-- 1. USERS
-- ============================================================

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'users') AND type = 'U')
BEGIN
    CREATE TABLE users (
        id BIGINT IDENTITY(1,1) PRIMARY KEY,
        role VARCHAR(20) NOT NULL CHECK (role IN ('customer', 'restaurant_owner', 'delivery_partner')),
        name VARCHAR(100) NOT NULL CHECK (LEN(TRIM(name)) >= 2),
        email VARCHAR(100) NOT NULL UNIQUE CHECK (email LIKE '%_@_%._%'),
        phone_number VARCHAR(11) NOT NULL UNIQUE CHECK (phone_number LIKE '01[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]'),
        password VARCHAR(255) NOT NULL,
        is_active TINYINT NOT NULL DEFAULT 1 CHECK (is_active IN (0, 1)),
        created_at DATETIME NULL
    );
END

-- ============================================================
-- 2. CUSTOMER PROFILES
-- ============================================================

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'customer_profiles') AND type = 'U')
BEGIN
    CREATE TABLE customer_profiles (
        customer_id BIGINT PRIMARY KEY FOREIGN KEY REFERENCES users(id),
        created_at DATETIME NULL
    );
END

-- ============================================================
-- 3. CUSTOMER ADDRESSES
-- ============================================================

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'customer_addresses') AND type = 'U')
BEGIN
    CREATE TABLE customer_addresses (
        address_id BIGINT IDENTITY(1,1) PRIMARY KEY,
        customer_id BIGINT NOT NULL FOREIGN KEY REFERENCES customer_profiles(customer_id),
        label VARCHAR(50) NOT NULL CHECK (LEN(TRIM(label)) >= 1),
        address_line VARCHAR(255) NOT NULL CHECK (LEN(TRIM(address_line)) >= 5),
        city VARCHAR(100) NOT NULL CHECK (LEN(TRIM(city)) >= 2),
        is_default TINYINT NOT NULL DEFAULT 0 CHECK (is_default IN (0, 1))
    );
END

-- ============================================================
-- 4. CUISINE TYPES
-- ============================================================

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'cuisine_types') AND type = 'U')
BEGIN
    CREATE TABLE cuisine_types (
        cuisine_id INT IDENTITY(1,1) PRIMARY KEY,
        cuisine_name VARCHAR(100) NOT NULL UNIQUE CHECK (LEN(TRIM(cuisine_name)) >= 2),
        description VARCHAR(255) NULL,
        cuisine_image VARCHAR(500) NOT NULL
    );
END

-- ============================================================
-- 5. RESTAURANT OWNER PROFILES
-- ============================================================

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'restaurant_owner_profiles') AND type = 'U')
BEGIN
    CREATE TABLE restaurant_owner_profiles (
        owner_id BIGINT PRIMARY KEY FOREIGN KEY REFERENCES users(id),
        created_at DATETIME NULL
    );
END

-- ============================================================
-- 6. RESTAURANTS
-- ============================================================

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'restaurants') AND type = 'U')
BEGIN
    CREATE TABLE restaurants (
        restaurant_id INT IDENTITY(1,1) PRIMARY KEY,
        owner_id BIGINT NULL FOREIGN KEY REFERENCES restaurant_owner_profiles(owner_id),
        name VARCHAR(255) NOT NULL CHECK (LEN(TRIM(name)) >= 2),
        location VARCHAR(255) NOT NULL CHECK (LEN(TRIM(location)) >= 5),
        phone_number VARCHAR(11) NOT NULL UNIQUE CHECK (phone_number LIKE '01[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]'),
        profile_image VARCHAR(500) NOT NULL,
        cover_image VARCHAR(500) NULL,
        open_status TINYINT NOT NULL DEFAULT 1 CHECK (open_status IN (0, 1)),
        created_at DATETIME NULL
    );
END

-- ============================================================
-- 7. RESTAURANT CUISINES
-- ============================================================

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'restaurant_cuisines') AND type = 'U')
BEGIN
    CREATE TABLE restaurant_cuisines (
        restaurant_id INT NOT NULL FOREIGN KEY REFERENCES restaurants(restaurant_id),
        cuisine_id INT NOT NULL FOREIGN KEY REFERENCES cuisine_types(cuisine_id),
        PRIMARY KEY (restaurant_id, cuisine_id)
    );
END

-- ============================================================
-- 8. RESTAURANT RATINGS
-- ============================================================

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'restaurant_ratings') AND type = 'U')
BEGIN
    CREATE TABLE restaurant_ratings (
        rating_id INT IDENTITY(1,1) PRIMARY KEY,
        restaurant_id INT NOT NULL UNIQUE FOREIGN KEY REFERENCES restaurants(restaurant_id),
        avg_rating DECIMAL(3,2) NOT NULL DEFAULT 0.00 CHECK (avg_rating BETWEEN 0.00 AND 5.00),
        total_reviews INT NOT NULL DEFAULT 0 CHECK (total_reviews >= 0)
    );
END

-- ============================================================
-- 9. MENU CATEGORIES
-- ============================================================

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'menu_categories') AND type = 'U')
BEGIN
    CREATE TABLE menu_categories (
        category_id INT IDENTITY(1,1) PRIMARY KEY,
        restaurant_id INT NOT NULL FOREIGN KEY REFERENCES restaurants(restaurant_id),
        category_name VARCHAR(100) NOT NULL CHECK (LEN(TRIM(category_name)) >= 1),
        display_order INT NOT NULL DEFAULT 0 CHECK (display_order >= 0)
    );
END

-- ============================================================
-- 10. MENU ITEMS
-- ============================================================

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'menu_items') AND type = 'U')
BEGIN
    CREATE TABLE menu_items (
        item_id INT IDENTITY(1,1) PRIMARY KEY,
        restaurant_id INT NOT NULL FOREIGN KEY REFERENCES restaurants(restaurant_id),
        category_id INT NULL FOREIGN KEY REFERENCES menu_categories(category_id),
        cuisine_id INT NULL FOREIGN KEY REFERENCES cuisine_types(cuisine_id),
        item_name VARCHAR(100) NOT NULL CHECK (LEN(TRIM(item_name)) >= 1),
        description VARCHAR(255) NULL,
        item_image VARCHAR(500) NOT NULL,
        price DECIMAL(10,2) NOT NULL CHECK (price > 0),
        is_available TINYINT NOT NULL DEFAULT 1 CHECK (is_available IN (0, 1)),
        created_at DATETIME NULL,
        CONSTRAINT uq_item_name_per_restaurant UNIQUE (restaurant_id, item_name)
    );
END

-- ============================================================
-- 11. OFFERS
-- ============================================================

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'offers') AND type = 'U')
BEGIN
    CREATE TABLE offers (
        offer_id INT IDENTITY(1,1) PRIMARY KEY,
        restaurant_id INT NOT NULL FOREIGN KEY REFERENCES restaurants(restaurant_id),
        offer_title VARCHAR(150) NOT NULL CHECK (LEN(TRIM(offer_title)) >= 3),
        discount_type VARCHAR(20) NOT NULL CHECK (discount_type IN ('percentage', 'flat', 'free_delivery')),
        discount_value DECIMAL(8,2) NULL CHECK (discount_value IS NULL OR discount_value > 0),
        target_type VARCHAR(20) NOT NULL CHECK (target_type IN ('item', 'category', 'restaurant')),
        target_item_id INT NULL FOREIGN KEY REFERENCES menu_items(item_id),
        target_category_id INT NULL FOREIGN KEY REFERENCES menu_categories(category_id),
        min_order_amount DECIMAL(10,2) NULL CHECK (min_order_amount IS NULL OR min_order_amount > 0),
        start_datetime DATETIME NOT NULL,
        end_datetime DATETIME NOT NULL,
        is_active TINYINT NOT NULL DEFAULT 1 CHECK (is_active IN (0, 1)),
        created_at DATETIME NULL,
        CONSTRAINT chk_offer_dates CHECK (end_datetime > start_datetime)
    );
END

-- ============================================================
-- 12. CART
-- ============================================================

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'cart') AND type = 'U')
BEGIN
    CREATE TABLE cart (
        cart_id INT IDENTITY(1,1) PRIMARY KEY,
        customer_id BIGINT NOT NULL FOREIGN KEY REFERENCES customer_profiles(customer_id),
        restaurant_id INT NOT NULL FOREIGN KEY REFERENCES restaurants(restaurant_id),
        created_at DATETIME NOT NULL DEFAULT GETDATE(),
        status VARCHAR(25) NOT NULL DEFAULT 'active' CHECK (status IN ('active', 'converted_to_order', 'abandoned'))
    );
END

-- ============================================================
-- 13. CART ITEMS
-- ============================================================

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'cart_items') AND type = 'U')
BEGIN
    CREATE TABLE cart_items (
        cart_item_id INT IDENTITY(1,1) PRIMARY KEY,
        cart_id INT NOT NULL FOREIGN KEY REFERENCES cart(cart_id),
        item_id INT NOT NULL FOREIGN KEY REFERENCES menu_items(item_id),
        quantity INT NOT NULL CHECK (quantity >= 1),
        unit_price DECIMAL(10,2) NOT NULL CHECK (unit_price > 0)
    );
END

-- ============================================================
-- 14. ORDERS
-- ============================================================

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'orders') AND type = 'U')
BEGIN
    CREATE TABLE orders (
        order_id INT IDENTITY(1,1) PRIMARY KEY,
        customer_id BIGINT NOT NULL FOREIGN KEY REFERENCES customer_profiles(customer_id),
        restaurant_id INT NOT NULL FOREIGN KEY REFERENCES restaurants(restaurant_id),
        cart_id INT NULL FOREIGN KEY REFERENCES cart(cart_id),
        delivery_address_id BIGINT NULL FOREIGN KEY REFERENCES customer_addresses(address_id),
        offer_id INT NULL FOREIGN KEY REFERENCES offers(offer_id),
        order_datetime DATETIME NOT NULL DEFAULT GETDATE(),
        order_status VARCHAR(50) NOT NULL CHECK (order_status IN ('pending','confirmed','preparing','ready','on_the_way','delivered','cancelled')),
        subtotal DECIMAL(10,2) NOT NULL CHECK (subtotal >= 0),
        discount_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00 CHECK (discount_amount >= 0),
        delivery_fee DECIMAL(10,2) NOT NULL DEFAULT 0.00 CHECK (delivery_fee >= 0),
        total_amount DECIMAL(10,2) NOT NULL CHECK (total_amount >= 0)
    );
END

-- ============================================================
-- 15. PAYMENTS
-- ============================================================

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'payments') AND type = 'U')
BEGIN
    CREATE TABLE payments (
        payment_id INT IDENTITY(1,1) PRIMARY KEY,
        order_id INT NOT NULL UNIQUE FOREIGN KEY REFERENCES orders(order_id),
        customer_id BIGINT NOT NULL FOREIGN KEY REFERENCES customer_profiles(customer_id),
        payment_method VARCHAR(50) NOT NULL CHECK (payment_method IN ('cash','card','bkash','nagad','credit')),
        payment_status VARCHAR(50) NOT NULL CHECK (payment_status IN ('pending','paid','failed','refunded')),
        amount_paid DECIMAL(10,2) NOT NULL CHECK (amount_paid >= 0),
        payment_datetime DATETIME NOT NULL DEFAULT GETDATE(),
        transaction_ref VARCHAR(100) NULL UNIQUE
    );
END

-- ============================================================
-- 16. DELIVERY PARTNER PROFILES
-- ============================================================

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'delivery_partner_profiles') AND type = 'U')
BEGIN
    CREATE TABLE delivery_partner_profiles (
        partner_id BIGINT PRIMARY KEY FOREIGN KEY REFERENCES users(id),
        vehicle_type VARCHAR(50) NOT NULL CHECK (vehicle_type IN ('bike', 'scooter', 'bicycle', 'car')),
        is_available TINYINT NOT NULL DEFAULT 1 CHECK (is_available IN (0, 1)),
        avg_rating DECIMAL(3,2) NOT NULL DEFAULT 0.00 CHECK (avg_rating BETWEEN 0.00 AND 5.00),
        created_at DATETIME NULL
    );
END

-- ============================================================
-- 17. DELIVERIES
-- ============================================================

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'deliveries') AND type = 'U')
BEGIN
    CREATE TABLE deliveries (
        delivery_id INT IDENTITY(1,1) PRIMARY KEY,
        order_id INT NOT NULL UNIQUE FOREIGN KEY REFERENCES orders(order_id),
        partner_id BIGINT NULL FOREIGN KEY REFERENCES delivery_partner_profiles(partner_id),
        delivery_address_id BIGINT NULL FOREIGN KEY REFERENCES customer_addresses(address_id),
        pickup_time DATETIME NULL,
        delivered_time DATETIME NULL,
        estimated_arrival DATETIME NULL,
        delivery_status VARCHAR(50) NOT NULL CHECK (delivery_status IN ('assigned','picked_up','on_the_way','delivered','failed'))
    );
END

-- ============================================================
-- 18. REVIEWS
-- ============================================================

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'reviews') AND type = 'U')
BEGIN
    CREATE TABLE reviews (
        review_id INT IDENTITY(1,1) PRIMARY KEY,
        order_id INT NOT NULL UNIQUE FOREIGN KEY REFERENCES orders(order_id),
        customer_id BIGINT NOT NULL FOREIGN KEY REFERENCES customer_profiles(customer_id),
        restaurant_id INT NOT NULL FOREIGN KEY REFERENCES restaurants(restaurant_id),
        partner_id BIGINT NULL FOREIGN KEY REFERENCES delivery_partner_profiles(partner_id),
        restaurant_rating TINYINT NOT NULL CHECK (restaurant_rating BETWEEN 1 AND 5),
        delivery_rating TINYINT NULL CHECK (delivery_rating BETWEEN 1 AND 5),
        comment VARCHAR(500) NULL,
        review_datetime DATETIME NOT NULL DEFAULT GETDATE()
    );
END