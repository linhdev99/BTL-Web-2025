<?php
/**
 * Web-based migration script for news table
 * Access via: http://localhost:8080/migrate_news.php
 */

require_once __DIR__ . '/config/config.php';

// Simple authentication - comment out if needed
if (!isset($_GET['run']) || $_GET['run'] !== 'yes') {
    die('To run migration, add ?run=yes to URL');
}

header('Content-Type: text/plain; charset=utf-8');

try {
    $db = Database::getInstance()->getConnection();

    echo "=== NEWS TABLE MIGRATION ===\n\n";

    // Step 1: Backup existing table
    echo "Step 1: Backing up existing news table...\n";
    try {
        $db->exec("DROP TABLE IF EXISTS news_backup_old");
        $db->exec("CREATE TABLE news_backup_old LIKE news");
        $db->exec("INSERT INTO news_backup_old SELECT * FROM news");
        $result = $db->query("SELECT COUNT(*) as count FROM news_backup_old");
        $count = $result->fetch(PDO::FETCH_ASSOC)['count'];
        echo "✓ Backed up $count records to news_backup_old\n\n";
    } catch (Exception $e) {
        echo "⚠ Warning: Could not backup (table might not exist): " . $e->getMessage() . "\n\n";
    }

    // Step 2: Drop old table
    echo "Step 2: Dropping old news table...\n";
    $db->exec("DROP TABLE IF EXISTS news");
    echo "✓ Dropped old table\n\n";

    // Step 3: Create new table with BTL-Web-2025 schema
    echo "Step 3: Creating new news table with BTL-Web-2025 schema...\n";
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
    echo "✓ Created new news table\n\n";

    // Step 4: Try to migrate old data
    echo "Step 4: Attempting to migrate old data...\n";
    try {
        $checkBackup = $db->query("SELECT COUNT(*) as count FROM news_backup_old");
        $backupCount = $checkBackup->fetch(PDO::FETCH_ASSOC)['count'];

        if ($backupCount > 0) {
            // Detect columns in backup table
            $columns = $db->query("SHOW COLUMNS FROM news_backup_old")->fetchAll(PDO::FETCH_COLUMN);

            $hasExcerpt = in_array('excerpt', $columns);
            $hasImage = in_array('image', $columns);
            $hasStatus = in_array('status', $columns);
            $hasSlug = in_array('slug', $columns);

            echo "Detected columns: " . implode(', ', array_filter([
                $hasExcerpt ? 'excerpt' : null,
                $hasImage ? 'image' : null,
                $hasStatus ? 'status' : null,
                $hasSlug ? 'slug' : null
            ])) . "\n";

            // Build migration query based on available columns
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
            echo "✓ Successfully migrated $backupCount records\n\n";
        } else {
            echo "⚠ No data to migrate\n\n";
        }
    } catch (Exception $e) {
        echo "⚠ Could not migrate old data: " . $e->getMessage() . "\n";
        echo "  You can manually check news_backup_old table if needed\n\n";
    }

    echo "=== MIGRATION COMPLETED SUCCESSFULLY ===\n\n";
    echo "New table structure:\n";
    echo "- id, user_id, title, summary, content, thumbnail\n";
    echo "- published_at, is_published, created_at, updated_at\n\n";

    echo "You can now delete this file (migrate_news.php) for security.\n";

} catch (Exception $e) {
    echo "\n❌ MIGRATION FAILED: " . $e->getMessage() . "\n";
    echo "\nStack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}
