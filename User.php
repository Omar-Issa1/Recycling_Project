<?php
require_once 'config.php';

class User {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    // login function
    public function login($username, $password) {
        try {
           
            $sql = "SELECT user_id, username, password_hash, points, balance 
                    FROM user_information 
                    WHERE username = :username";
                    
            $stmt = $this->db->query($sql, [':username' => $username]);
            $user = $this->db->fetchOne($stmt);
            
            if ($user && password_verify($password, $user['PASSWORD_HASH'])) {
                $_SESSION['user_id'] = $user['USER_ID'];
                $_SESSION['username'] = $user['USERNAME'];
                $_SESSION['points'] = $user['POINTS'];
                $_SESSION['balance'] = $user['BALANCE'];
                
                return ['success' => true, 'message' => 'تم تسجيل الدخول بنجاح'];
            } else {
                return ['success' => false, 'message' => 'اسم المستخدم أو كلمة المرور غير صحيحة'];
            }
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'حدث خطأ: ' . $e->getMessage()];
        }
    }


    public function register($username, $password, $email, $phone, $address) {
        try {
            $checkSql = "SELECT count(*) as cnt FROM user_information WHERE username = :username";
            $stmt = $this->db->query($checkSql, [':username' => $username]);
            $result = $this->db->fetchOne($stmt);
            
           if ($result['cnt'] > 0) {

                return ['success' => false, 'message' => 'اسم المستخدم موجود بالفعل'];
            }
            
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $qr_code = rand(100000000, 999999999);
            
            $this->db->query("INSERT INTO serial_number (Qr_code) VALUES (:qr)", [':qr' => $qr_code]);
            
           
            $sql = "INSERT INTO user_information (username, password_hash, user_email, user_phone, user_address, Qr_code, points, balance) 
                    VALUES (:username, :pass, :email, :phone, :address, :qr, 0, 0)";
            
            $params = [
                ':username' => $username,
                ':pass' => $password_hash,
                ':email' => $email,
                ':phone' => $phone,
                ':address' => $address,
                ':qr' => $qr_code
            ];
            
            $this->db->query($sql, $params);
            
            return ['success' => true, 'message' => 'تم إنشاء الحساب بنجاح'];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'خطأ في التسجيل: ' . $e->getMessage()];
        }
    }
    
    public function updatePoints($user_id, $points) {
        try {
            $sql = "UPDATE user_information 
                    SET points = COALESCE(points, 0) + :points 
                    WHERE user_id = :user_id";
            
            $this->db->query($sql, [':points' => $points, ':user_id' => $user_id]);
            
            if(isset($_SESSION['points'])) { $_SESSION['points'] += $points; }
            
            return ['success' => true];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function updateBalance($user_id, $amount) {
        try {
            $sql = "UPDATE user_information 
                    SET balance = COALESCE(balance, 0) + :amount 
                    WHERE user_id = :user_id";
            
            $this->db->query($sql, [':amount' => $amount, ':user_id' => $user_id]);
            
            if(isset($_SESSION['balance'])) { $_SESSION['balance'] += $amount; }

            return ['success' => true];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
?>