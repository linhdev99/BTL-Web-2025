USE `bkshop`;
-- Roles
INSERT INTO roles (name, description)
VALUES ('admin', 'Administrator'),
    ('user', 'Regular customer');
-- Admin user (⚠ replace password hash later)
INSERT INTO users (
        role_id,
        email,
        password,
        full_name,
        phone,
        is_active
    )
VALUES (
        1,
        'admin@bkshop.com',
        '$2y$10$EXAMPLE_HASH_REPLACE_ME',
        'BKShop Admin',
        '0123456789',
        1
    );
-- Categories
INSERT INTO categories (name, slug, description)
VALUES (
        'Anime Figures',
        'anime-figures',
        'High-quality anime character models'
    ),
    (
        'Game Figures',
        'game-figures',
        'Collectible figures from popular games'
    ),
    (
        'Robots',
        'robots',
        'Model kits and robot figures'
    ),
    (
        'Vehicles',
        'vehicles',
        'Cars, bikes, and mechanical model kits'
    );
-- Brands
INSERT INTO brands (name, slug, description, country)
VALUES (
        'Bandai',
        'bandai',
        'Japanese toy and plastic model manufacturer',
        'Japan'
    ),
    (
        'Kotobukiya',
        'kotobukiya',
        'Japanese model and figure company',
        'Japan'
    ),
    (
        'Good Smile Company',
        'good-smile',
        'Famous for Nendoroid and Figma series',
        'Japan'
    ),
    (
        'Tamiya',
        'tamiya',
        'Model car and military kits brand',
        'Japan'
    );
-- Products (3D figures / models)
INSERT INTO products (
        category_id,
        brand_id,
        sku,
        name,
        slug,
        short_description,
        scale,
        material,
        price,
        sale_price,
        stock,
        is_active
    )
VALUES (
        1,
        3,
        'SKU-001',
        'Hatsune Miku Figma',
        'hatsune-miku-figma',
        '1/7 scale figure of Hatsune Miku',
        '1/7',
        'PVC',
        89.99,
        79.99,
        30,
        1
    ),
    (
        2,
        1,
        'SKU-002',
        'Cloud Strife Figure',
        'cloud-strife-figure',
        'Final Fantasy VII hero 1/8 scale',
        '1/8',
        'ABS',
        119.00,
        NULL,
        20,
        1
    ),
    (
        3,
        2,
        'SKU-003',
        'Gundam RX-78-2 Model Kit',
        'gundam-rx78-2',
        'Master Grade Gundam model',
        '1/100',
        'Plastic',
        59.90,
        49.90,
        100,
        1
    ),
    (
        4,
        4,
        'SKU-004',
        'Tamiya Porsche 911 GT3',
        'porsche-911-gt3',
        'Detailed model car kit',
        '1/24',
        'Resin',
        65.00,
        55.00,
        40,
        1
    );
-- Product Images
INSERT INTO product_images (product_id, file_name, is_main)
VALUES (1, 'products/miku-main.jpg', 1),
    (1, 'products/miku-side.jpg', 0),
    (3, 'products/gundam-main.jpg', 1),
    (4, 'products/porsche-main.jpg', 1);
-- News / Blog
INSERT INTO news (
        user_id,
        title,
        slug,
        summary,
        content,
        thumbnail,
        published_at,
        is_published
    )
VALUES (
        NULL,
        'BKShop Grand Opening',
        'bkshop-opening',
        'BKShop officially launches!',
        'We are thrilled to announce the opening of BKShop – your go-to place for anime, robot, and model figures!',
        NULL,
        NOW(),
        1
    ),
    (
        NULL,
        'Top 5 New Anime Figures in 2025',
        'top-anime-figures-2025',
        'Our selection of the most popular figures this year',
        'Full article content here...',
        NULL,
        NOW(),
        1
    );
-- Contacts
INSERT INTO contacts (name, email, phone, subject, message)
VALUES (
        'John Doe',
        'john@example.com',
        '0987654321',
        'Inquiry about Gundam',
        'Do you have MG Zaku II model available?'
    );
-- Settings
INSERT INTO settings (`key`, `value`)
VALUES ('site_name', 'BKShop – 3D Figures & Model Kits'),
    ('site_email', 'support@bkshop.com'),
    ('site_phone', '+84-123-456-789'),
    ('site_address', 'Ho Chi Minh City, Vietnam');