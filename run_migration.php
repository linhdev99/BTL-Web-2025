#!/usr/bin/env php
<?php
/**
 * CLI Migration Script for News Table
 * Run: php run_migration.php
 */

// Change to script directory
chdir(__DIR__);

require_once __DIR__ . '/config/config.php';

echo "\n";
echo "╔══════════════════════════════════════════════════════════╗\n";
echo "║          NEWS TABLE MIGRATION - BTL-Web-2025             ║\n";
echo "╚══════════════════════════════════════════════════════════╝\n";
echo "\n";

try {
    $db = Database::getInstance()->getConnection();

    // Step 1: Backup
    echo "Step 1: Backing up existing news table...\n";
    try {
        $db->exec("DROP TABLE IF EXISTS news_backup_old");
        $db->exec("CREATE TABLE news_backup_old LIKE news");
        $db->exec("INSERT INTO news_backup_old SELECT * FROM news");
        $result = $db->query("SELECT COUNT(*) as count FROM news_backup_old");
        $count = $result->fetch(PDO::FETCH_ASSOC)['count'];
        echo "        ✓ Backed up $count records to news_backup_old\n\n";
    } catch (Exception $e) {
        echo "        ⚠ Warning: Could not backup: " . $e->getMessage() . "\n\n";
    }

    // Step 2: Drop old table
    echo "Step 2: Dropping old news table...\n";
    $db->exec("DROP TABLE IF EXISTS news");
    echo "        ✓ Dropped old table\n\n";

    // Step 3: Create new table
    echo "Step 3: Creating new news table...\n";
    $createSQL = "
    CREATE TABLE `news` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `user_id` int(11) DEFAULT NULL,
      `title` varchar(255) NOT NULL,
      `summary` text,
      `content` text NOT NULL,
      `thumbnail` varchar(255) DEFAULT NULL,
      `published_at` datetime DEFAULT NULL,
      `is_published` tinyint(1) DEFAULT 0,
      `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `user_id` (`user_id`),
      KEY `is_published` (`is_published`),
      KEY `published_at` (`published_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ";

    $db->exec($createSQL);
    echo "        ✓ Created new table with BTL-Web-2025 schema\n\n";

    // Step 4: Migrate data
    echo "Step 4: Migrating old data...\n";
    try {
        $checkBackup = $db->query("SELECT COUNT(*) as count FROM news_backup_old");
        $backupCount = $checkBackup->fetch(PDO::FETCH_ASSOC)['count'];

        if ($backupCount > 0) {
            // Check available columns
            $columns = $db->query("SHOW COLUMNS FROM news_backup_old")->fetchAll(PDO::FETCH_COLUMN);

            $hasExcerpt = in_array('excerpt', $columns);
            $hasImage = in_array('image', $columns);
            $hasStatus = in_array('status', $columns);

            echo "        Detected old columns: " . implode(', ', $columns) . "\n";

            // Build migration query
            $summaryCol = $hasExcerpt ? "COALESCE(excerpt, LEFT(content, 200))" : "LEFT(content, 200)";
            $thumbnailCol = $hasImage ? "image" : "NULL";
            $isPublishedCol = $hasStatus ? "IF(status = 'published', 1, 0)" : "0";

            $migrateSQL = "
            INSERT INTO news (user_id, title, summary, content, thumbnail, published_at, is_published, created_at, updated_at)
            SELECT
                user_id,
                title,
                $summaryCol as summary,
                content,
                $thumbnailCol as thumbnail,
                COALESCE(published_at, created_at) as published_at,
                $isPublishedCol as is_published,
                created_at,
                COALESCE(updated_at, created_at) as updated_at
            FROM news_backup_old
            ";

            $db->exec($migrateSQL);
            echo "        ✓ Migrated $backupCount records successfully\n\n";
        } else {
            echo "        ℹ No old data to migrate\n\n";
        }
    } catch (Exception $e) {
        echo "        ⚠ Could not migrate data: " . $e->getMessage() . "\n";
        echo "        Old data is still available in news_backup_old\n\n";
    }

    // Step 5: Verify
    echo "Step 5: Verifying new table...\n";
    $newCount = $db->query("SELECT COUNT(*) as count FROM news")->fetch(PDO::FETCH_ASSOC)['count'];
    $columns = $db->query("SHOW COLUMNS FROM news")->fetchAll(PDO::FETCH_COLUMN);

    echo "        Columns: " . implode(', ', $columns) . "\n";
    echo "        Records: $newCount\n\n";

    echo "╔══════════════════════════════════════════════════════════╗\n";
    echo "║                  MIGRATION SUCCESSFUL!                    ║\n";
    echo "╚══════════════════════════════════════════════════════════╝\n";
    echo "\n";
    echo "You can now:\n";
    echo "  - Create/edit news articles in the CMS\n";
    echo "  - Delete this file (run_migration.php) for security\n";
    echo "  - Check news_backup_old if you need old data\n";
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
