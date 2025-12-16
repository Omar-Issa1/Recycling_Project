<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Database {
    private $conn;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $databaseUrl = getenv('DATABASE_URL');
        if (!$databaseUrl) {
            die('DB ERROR');
        }

        $db = parse_url($databaseUrl);

        $dsn = "pgsql:host={$db['host']};port={$db['port']};dbname=" .
               ltrim($db['path'], '/') . ";sslmode=require";

        $this->conn = new PDO($dsn, $db['user'], $db['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

    public function query($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->execute();
        return $stmt;
    }

    public function fetchOne($stmt) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll($stmt) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
