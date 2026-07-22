<?php

namespace App\Database;

require_once(__DIR__ . '/../../config/config.php');

class DBConnect
{
    private static ?DBConnect $instance = null;
    private \PDO $pdo;

    private function __construct()
    {
        $this->connect();
    }

    public static function getInstance(): DBConnect
    {
        if (self::$instance === null) {
            self::$instance = new DBConnect();
        }
        return self::$instance;
    }

    private function connect(): void
    {
        try {
            $this->pdo = new \PDO(
                "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_NAME,
                MYSQL_USER,
                MYSQL_PASSWORD,
            );
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Error connection: " . $e->getMessage());
        }
    }

    public function getConnection(): \PDO
    {
        return $this->pdo;
    }
}
