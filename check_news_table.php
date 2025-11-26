<?php
/**
 * Check current news table structure
 * Access via browser or run: php check_news_table.php
 */

require_once __DIR__ . '/config/config.php';

header('Content-Type: text/plain; charset=utf-8');

try {
    $db = Database::getInstance()->getConnection();

    echo "=== CHECKING NEWS TABLE ===\n\n";

    // Check if table exists
    $tableExists = $db->query("SHOW TABLES LIKE 'news'")->fetch();

    if (!$tableExists) {
        echo "❌ Table 'news' does NOT exist!\n\n";
        echo "You need to create it first.\n";
        exit;
    }

    echo "✓ Table 'news' exists\n\n";

    // Show current structure
    echo "Current columns:\n";
    echo str_repeat("-", 80) . "\n";

    $columns = $db->query("SHOW COLUMNS FROM news")->fetchAll(PDO::FETCH_ASSOC);

    foreach ($columns as $col) {
        printf("%-20s %-30s %s\n",
            $col['Field'],
            $col['Type'],
            $col['Null'] === 'NO' ? 'NOT NULL' : 'NULL'
        );
    }

    echo str_repeat("-", 80) . "\n\n";

    // Check for required BTL-Web-2025 columns
    $requiredColumns = ['id', 'user_id', 'title', 'summary', 'content', 'thumbnail', 'published_at', 'is_published', 'created_at', 'updated_at'];
    $existingColumns = array_column($columns, 'Field');

    $missing = array_diff($requiredColumns, $existingColumns);
    $extra = array_diff($existingColumns, $requiredColumns);

    if (empty($missing)) {
        echo "✓ All required BTL-Web-2025 columns are present!\n";
    } else {
        echo "❌ Missing columns: " . implode(', ', $missing) . "\n";
    }

    if (!empty($extra)) {
        echo "⚠ Extra columns (old schema): " . implode(', ', $extra) . "\n";
    }

    echo "\n";

    // Count records
    $count = $db->query("SELECT COUNT(*) FROM news")->fetchColumn();
    echo "Total records: $count\n\n";

    if (!empty($missing)) {
        echo "SOLUTION: You need to run the migration to update the table structure.\n";
        echo "Run: php migrate_news.php (or access via browser)\n";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
