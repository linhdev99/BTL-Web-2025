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

            // Load config
            require __DIR__ . '/../configs/config.development.php';

            try {
                $dsn = "mysql:host={$database_server};port={$database_port};dbname={$database_name};charset=utf8mb4";

                self::$instance = new PDO($dsn, $database_username, $database_password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
