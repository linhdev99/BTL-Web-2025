<?php

namespace Database;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            // Database configuration (from define-params.php)
            $host = defined('DB_HOST') ? DB_HOST : 'localhost';
            $dbname = defined('DB_NAME') ? DB_NAME : 'toy_shop';
            $username = defined('DB_USER') ? DB_USER : 'root';
            $password = defined('DB_PASS') ? DB_PASS : '';
            $charset = defined('DB_CHARSET') ? DB_CHARSET : 'utf8mb4';
            $port = defined('DB_PORT') ? DB_PORT : '3306';

            try {
                // Try with socket path first (for macOS MAMP/XAMPP)
                $socketPaths = [
                    '/Applications/MAMP/tmp/mysql/mysql.sock',
                    '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock',
                    '/tmp/mysql.sock'
                ];

                $connected = false;

                // Try socket paths for macOS
                foreach ($socketPaths as $socket) {
                    if (file_exists($socket)) {
                        try {
                            $dsn = "mysql:unix_socket={$socket};dbname={$dbname};charset={$charset}";
                            self::$instance = new PDO($dsn, $username, $password, [
                                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                                PDO::ATTR_EMULATE_PREPARES => false
                            ]);
                            $connected = true;
                            break;
                        } catch (PDOException $e) {
                            continue;
                        }
                    }
                }

                // Fallback to host:port connection
                if (!$connected) {
                    $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}";
                    self::$instance = new PDO($dsn, $username, $password, [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false
                    ]);
                }
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$instance;
    }

    // Prevent cloning
    private function __clone() {}

    // Prevent unserializing
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }
}
