<?php
// ❗❗ لازم يكون أول سطر في الملف (مفيش مسافات ولا سطر فاضي قبله)

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Database {
    private $conn;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        try {
            $databaseUrl = getenv('DATABASE_URL');
            if (!$databaseUrl) {
                throw new Exception("DATABASE_URL not set");
            }

            $db = parse_url($databaseUrl);

            $host   = $db['host'] ?? null;
            $port   = $db['port'] ?? 5432;
            $dbname = isset($db['path']) ? ltrim($db['path'], '/') : null;
            $user   = $db['user'] ?? null;
            $pass   = $db['pass'] ?? null;

            if (!$host || !$dbname || !$user) {
                throw new Exception("Invalid DATABASE_URL");
            }

            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";

            $this->conn = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);
        } catch (Exception $e) {
            die("DB ERROR");
        }
    }

    public function query($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
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

