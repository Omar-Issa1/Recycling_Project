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
            die('DATABASE_URL not set');
        }

        $db = parse_url($databaseUrl);

        $host   = $db['host'] ?? null;
        $user   = $db['user'] ?? null;
        $pass   = $db['pass'] ?? null;
        $dbname = isset($db['path']) ? ltrim($db['path'], '/') : null;
        $port   = $db['port'] ?? 5432;

        if (!$host || !$user || !$dbname) {
            die('Invalid DATABASE_URL');
        }

        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";

        $this->conn = new PDO($dsn, $user, $pass, [
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

/* helpers */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function redirect($url) {
    header("Location: $url");
    exit;
}

function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}
