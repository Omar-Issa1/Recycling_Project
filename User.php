<?php
require_once 'config.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // ✅ LOGIN بدون HASH
    public function login($username, $password) {

        $sql = "SELECT user_id, username, password_hash, points, balance
                FROM user_information
                WHERE username = :username
                AND password_hash = :password";

        $stmt = $this->db->query($sql, [
            ':username' => $username,
            ':password' => $password
        ]);

        $user = $this->db->fetchOne($stmt);

        if (!$user) {
            return ['success' => false, 'message' => 'اسم المستخدم أو كلمة المرور غير صحيحة'];
        }

        // ✅ SESSION
        $_SESSION['user_id']  = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['points']   = $user['points'];
        $_SESSION['balance']  = $user['balance'];

        return ['success' => true, 'message' => 'تم تسجيل الدخول بنجاح'];
    }

    // ✅ REGISTER بدون HASH
    public function register($username, $password, $email, $phone, $address) {

        $check = $this->db->query(
            "SELECT 1 FROM user_information WHERE username = :u",
            [':u' => $username]
        );

        if ($check->fetch()) {
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
                ':p'  => $password,   // ✅ plain
                ':e'  => $email,
                ':ph' => $phone,
                ':a'  => $address,
                ':qr' => $qr
            ]
        );

        return ['success' => true, 'message' => 'تم إنشاء الحساب بنجاح'];
    }
}
