<?php
require_once 'config.php';

class Admin {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function getAllUsers() {
        try {
            $sql = "SELECT user_id, username, user_email, user_phone, balance, points 
                    FROM user_information 
                    ORDER BY user_id DESC";
            $stmt = $this->db->query($sql, []);
            return $this->db->fetchAll($stmt);
        } catch (Exception $e) {
            return [];
        }
    }
    
    public function searchUsers($search_term) {
        try {
            $search = '%' . $search_term . '%';
            
            $sql = "SELECT user_id, username, user_email, user_phone, balance, points 
                    FROM user_information 
                    WHERE LOWER(username) LIKE LOWER(:search) 
                    OR LOWER(user_email) LIKE LOWER(:search)
                    ORDER BY user_id DESC";
            $stmt = $this->db->query($sql, [':search' => $search]);
            return $this->db->fetchAll($stmt);
        } catch (Exception $e) {
            return [];
        }
    }
    
    public function updateUser($user_id, $username, $email, $phone, $balance, $points) {
        try {
            $sql = "UPDATE user_information 
                    SET username = :username, 
                        user_email = :email, 
                        user_phone = :phone, 
                        balance = :balance, 
                        points = :points 
                    WHERE user_id = :user_id";
            
            $params = [
                ':username' => $username,
                ':email' => $email,
                ':phone' => $phone,
                ':balance' => $balance,
                ':points' => $points,
                ':user_id' => $user_id
            ];
            
            $this->db->query($sql, $params);
            
            return ['success' => true, 'message' => 'تم تحديث المستخدم بنجاح'];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'حدث خطأ: ' . $e->getMessage()];
        }
    }
    
    public function deleteUser($user_id) {
        try {
            $sql = "DELETE FROM user_information WHERE user_id = :user_id";
            $this->db->query($sql, [':user_id' => $user_id]);
            
            return ['success' => true, 'message' => 'تم حذف المستخدم بنجاح'];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'حدث خطأ: ' . $e->getMessage()];
        }
    }
    
    public function getStatistics() {
        try {
            
            $sql_users = "SELECT COUNT(*) as total_users FROM user_information";
            $stmt_users = $this->db->query($sql_users, []);
            $users_result = $this->db->fetchOne($stmt_users);
            
            $sql_points = "SELECT COALESCE(SUM(points), 0) as total_points FROM user_information";
            $stmt_points = $this->db->query($sql_points, []);
            $points_result = $this->db->fetchOne($stmt_points);
            
            $sql_balance = "SELECT COALESCE(SUM(balance), 0) as total_balance FROM user_information";
            $stmt_balance = $this->db->query($sql_balance, []);
            $balance_result = $this->db->fetchOne($stmt_balance);
            
            $sql_materials = "SELECT COUNT(*) as total_materials FROM material";
            $stmt_materials = $this->db->query($sql_materials, []);
            $materials_result = $this->db->fetchOne($stmt_materials);
            
            return [
                'total_users' => $users_result['TOTAL_USERS'],
                'total_points' => $points_result['TOTAL_POINTS'],
                'total_balance' => $balance_result['TOTAL_BALANCE'],
                'total_materials' => $materials_result['TOTAL_MATERIALS']
            ];
            
        } catch (Exception $e) {
            return [
                'total_users' => 0,
                'total_points' => 0,
                'total_balance' => 0,
                'total_materials' => 0
            ];
        }
    }
    
    public function getAllDrivers() {
        try {
            $sql = "SELECT driver_id, username, driver_name, driver_phone, driver_email 
                    FROM driver 
                    ORDER BY driver_id DESC";
            $stmt = $this->db->query($sql, []);
            return $this->db->fetchAll($stmt);
        } catch (Exception $e) {
            return [];
        }
    }
    
    public function addDriver($username, $password, $name, $phone, $email) {
        try {
            $driver_id = $this->getNextDriverId();
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $qr_code = $this->generateQRCode();
            
            $sql_qr = "INSERT INTO serial_number (Qr_code) VALUES (:qr_code)";
            $this->db->query($sql_qr, [':qr_code' => $qr_code]);
            
            $sql = "INSERT INTO driver (driver_id, username, password_hash, driver_name, driver_phone, driver_email, Qr_code) 
                    VALUES (:driver_id, :username, :password_hash, :name, :phone, :email, :qr_code)";
            
            $params = [
                ':driver_id' => $driver_id,
                ':username' => $username,
                ':password_hash' => $password_hash,
                ':name' => $name,
                ':phone' => $phone,
                ':email' => $email,
                ':qr_code' => $qr_code
            ];
            
            $this->db->query($sql, $params);
            
            return ['success' => true, 'message' => 'تم إضافة السائق بنجاح'];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'حدث خطأ: ' . $e->getMessage()];
        }
    }
    
    public function deleteDriver($driver_id) {
        try {
            $sql = "DELETE FROM driver WHERE driver_id = :driver_id";
            $this->db->query($sql, [':driver_id' => $driver_id]);
            
            return ['success' => true, 'message' => 'تم حذف السائق بنجاح'];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'حدث خطأ: ' . $e->getMessage()];
        }
    }
    
    private function getNextDriverId() {
        $sql = "SELECT COALESCE(MAX(driver_id), 0) + 1 as next_id FROM driver";
        $stmt = $this->db->query($sql, []);
        $result = $this->db->fetchOne($stmt);
        return $result['NEXT_ID'];
    }
    
    private function generateQRCode() {
        return rand(100000000, 999999999);
    }
}
?>