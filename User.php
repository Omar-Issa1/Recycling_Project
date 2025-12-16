<?php
require_once 'config.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // ✅ LOGIN (plain password)
    public function login($username, $password) {

        $sql = "SELECT user_id, username, password_hash, points, balance
                FROM user_information
                WHERE username = :username";

        $stmt = $this->db->query($sql, [
            ':username' => $username
        ]);

        $user = $this->db->fetchOne($stmt);

        if (!$user) {
            return ['success' => false, 'message' => 'اسم المستخدم غير موجود'];
        }

        // ✅ مقارنة مباشرة
        if ($password !== $user['password_hash']) {
            return ['success' => false, 'message' => 'كلمة المرور غير صحيحة'];
        }

        $_SESSION['user_id']  = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['points']   = $user['points'];
        $_SESSION['balance']  = $user['balance'];

        return ['success' => true];
    }

    // ✅ REGISTER (plain password)
    public function register($username, $password, $email, $phone, $address) {

        $exists = $this->db->query(
            "SELECT 1 FROM user_information WHERE username = :u",
            [':u' => $username]
        )->fetch();

        if ($exists) {
            return ['success' => false, 'message' => 'اسم المستخدم موجود بالفعل'];
        }

        $qr = rand(100000000, 999999999);

        $this->db->query(
            "INSERT INTO serial_number (Qr_code) VALUES (:qr)",
            [':qr' => $qr]
        );

        $this->db->query(
            "INSERT INTO user_information
            (username, password_hash, user_email, user_phone, user_address, Qr_code, points, balance)
            VALUES (:u, :p, :e, :ph, :a, :qr, 0, 0)",
            [
                ':u'  => $username,
                ':p'  => $password, // 🔥 plain
                ':e'  => $email,
                ':ph' => $phone,
                ':a'  => $address,
                ':qr' => $qr
            ]
        );

        return ['success' => true];
    }
    public function updatePoints($user_id, $points) {
    $sql = "UPDATE user_information
            SET points = COALESCE(points, 0) + :points
            WHERE user_id = :user_id";

    $this->db->query($sql, [
        ':points' => $points,
        ':user_id' => $user_id
    ]);

    // تحديث السيشن عشان الـ Navbar
    if (isset($_SESSION['points'])) {
        $_SESSION['points'] += $points;
    }
}

}
