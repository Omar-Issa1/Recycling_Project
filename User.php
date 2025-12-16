<?php
require_once 'config.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // ✅ LOGIN بدون hash
    public function login($username, $password) {
        try {
            $sql = "SELECT user_id, username, password_hash, points, balance
                    FROM user_information
                    WHERE username = :username AND password_hash = :password";

            $stmt = $this->db->query($sql, [
                ':username' => $username,
                ':password' => $password
            ]);

            $user = $this->db->fetchOne($stmt);

            if ($user) {
                $_SESSION['user_id']  = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['points']   = $user['points'];
                $_SESSION['balance']  = $user['balance'];

                return ['success' => true, 'message' => 'تم تسجيل الدخول بنجاح'];
            }

            return ['success' => false, 'message' => 'اسم المستخدم أو كلمة المرور غير صحيحة'];

        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    // ✅ REGISTER بدون hash
    public function register($username, $password, $email, $phone, $address) {
        try {
            $checkSql = "SELECT COUNT(*) AS cnt FROM user_information WHERE username = :username";
            $stmt = $this->db->query($checkSql, [':username' => $username]);
            $result = $this->db->fetchOne($stmt);

            if (($result['cnt'] ?? 0) > 0) {
                return ['success' => false, 'message' => 'اسم المستخدم موجود بالفعل'];
            }

            $qr_code = rand(100000000, 999999999);

            $this->db->query(
                "INSERT INTO serial_number (Qr_code) VALUES (:qr)",
                [':qr' => $qr_code]
            );

            $sql = "INSERT INTO user_information
                    (username, password_hash, user_email, user_phone, user_address, Qr_code, points, balance)
                    VALUES (:username, :pass, :email, :phone, :address, :qr, 0, 0)";

            $this->db->query($sql, [
                ':username' => $username,
                ':pass'     => $password, // ⚠️ باسورد عادي
                ':email'    => $email,
                ':phone'    => $phone,
                ':address'  => $address,
                ':qr'       => $qr_code
            ]);

            return ['success' => true, 'message' => 'تم إنشاء الحساب بنجاح'];

        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
