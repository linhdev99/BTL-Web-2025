#!/usr/bin/env php
<?php
/**
 * Create carts table migration
 */

require_once __DIR__ . '/config/config.php';

echo "\n";
echo "╔══════════════════════════════════════════════════════════╗\n";
echo "║          CREATE CARTS TABLE - BTL-Web-2025               ║\n";
echo "╚══════════════════════════════════════════════════════════╝\n";
echo "\n";

try {
    $db = Database::getInstance()->getConnection();

    // Check if table exists
    echo "Checking if carts table exists...\n";
    $result = $db->query("SHOW TABLES LIKE 'carts'");

    if ($result->rowCount() > 0) {
        echo "✓ Carts table already exists\n\n";
        exit(0);
    }

    // Create carts table
    echo "Creating carts table...\n";

    $sql = "
    CREATE TABLE `carts` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `user_id` int(11) NOT NULL,
      `product_id` int(11) NOT NULL,
      `quantity` int(11) NOT NULL DEFAULT 1,
      `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `user_id` (`user_id`),
      KEY `product_id` (`product_id`),
      UNIQUE KEY `user_product` (`user_id`, `product_id`),
      CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
      CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ";

    $db->exec($sql);
    echo "✓ Carts table created successfully\n\n";

    // Verify
    echo "Verifying table structure...\n";
    $columns = $db->query("SHOW COLUMNS FROM carts")->fetchAll(PDO::FETCH_COLUMN);
    echo "Columns: " . implode(', ', $columns) . "\n\n";

    echo "╔══════════════════════════════════════════════════════════╗\n";
    echo "║              MIGRATION SUCCESSFUL!                        ║\n";
    echo "╚══════════════════════════════════════════════════════════╝\n";
    echo "\n";
    echo "Carts table has been created successfully!\n";
    echo "Users can now add products to their cart.\n";
    echo "\n";

} catch (Exception $e) {
    echo "\n";
    echo "╔══════════════════════════════════════════════════════════╗\n";
    echo "║                   MIGRATION FAILED!                       ║\n";
    echo "╚══════════════════════════════════════════════════════════╝\n";
    echo "\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "\n";
    exit(1);
}
