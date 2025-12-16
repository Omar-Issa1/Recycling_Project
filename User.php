<?php
require_once 'config.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function login($username, $password) {
        try {
            $sql = "SELECT user_id, username, password_hash, points, balance
                    FROM user_information
                    WHERE username = :username";

            $stmt = $this->db->query($sql, [':username' => $username]);
            $user = $this->db->fetchOne($stmt);

            if ($user && password_verify($password, $user['password_hash'])) {

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

    public function register($username, $password, $email, $phone, $address) {
        try {
            $checkSql = "SELECT COUNT(*) AS cnt FROM user_information WHERE username = :username";
            $stmt = $this->db->query($checkSql, [':username' => $username]);
            $result = $this->db->fetchOne($stmt);

            if (($result['cnt'] ?? 0) > 0) {
                return ['success' => false, 'message' => 'اسم المستخدم موجود بالفعل'];
            }

            $password_hash = password_hash($password, PASSWORD_DEFAULT);
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
                ':pass'     => $password_hash,
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

    public function updatePoints($user_id, $points) {
        $this->db->query(
            "UPDATE user_information
             SET points = COALESCE(points,0) + :points
             WHERE user_id = :id",
            [':points' => $points, ':id' => $user_id]
        );

        $_SESSION['points'] += $points;
    }

    public function updateBalance($user_id, $amount) {
        $this->db->query(
            "UPDATE user_information
             SET balance = COALESCE(balance,0) + :amount
             WHERE user_id = :id",
            [':amount' => $amount, ':id' => $user_id]
        );

        $_SESSION['balance'] += $amount;
    }
}
