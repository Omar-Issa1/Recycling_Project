<?php
require_once 'config.php';

class Material {
    private $db;
    
    // معدلات التحويل
    private $conversion_rates = [
        'plastic' => ['pieces' => 20, 'points' => 100],
        'glass' => ['pieces' => 20, 'points' => 100],
        'metal' => ['pieces' => 20, 'points' => 700],
        'electronics' => ['pieces' => 20, 'points' => 100]
    ];
    
    public function __construct() {
        $this->db = new Database();
    }
    // add new material
    public function addMaterial($material_type, $material_quantity, $qr_code = null) {
        try {
            $material_id = $this->getNextMaterialId();
            
            if ($qr_code === null) {
                $qr_code = $this->generateQRCode();
                $sql_qr = "INSERT INTO serial_number (Qr_code) VALUES (:qr_code)";
                $this->db->query($sql_qr, [':qr_code' => $qr_code]);
            }
            
            $sql = "INSERT INTO material (material_id, material_type, material_quantity, Qr_code) 
                    VALUES (:material_id, :material_type, :material_quantity, :qr_code)";
            
            $params = [
                ':material_id' => $material_id,
                ':material_type' => $material_type,
                ':material_quantity' => $material_quantity,
                ':qr_code' => $qr_code
            ];
            
            $this->db->query($sql, $params);
            
            return ['success' => true, 'message' => 'تم إضافة المادة بنجاح', 'material_id' => $material_id];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'حدث خطأ: ' . $e->getMessage()];
        }
    }
    

    public function calculatePoints($material_type, $quantity) {
        $material_type = strtolower($material_type);
        if (!isset($this->conversion_rates[$material_type])) return 0;
        $rate = $this->conversion_rates[$material_type];
        $sets = floor($quantity / $rate['pieces']);
        return $sets * $rate['points'];
    }

    public function exchangeForPoints($user_id, $material_type, $quantity) {
        try {
            $points = $this->calculatePoints($material_type, $quantity);
            if ($points <= 0) return ['success' => false, 'message' => 'الكمية غير كافية للتبديل'];
            
            $result = $this->addMaterial($material_type, $quantity);
            if (!$result['success']) return $result;
            
            require_once 'User.php';
            $user = new User();
            $update_result = $user->updatePoints($user_id, $points);
            
            if ($update_result['success']) {
                return ['success' => true, 'message' => 'تم التبديل بنجاح', 'points_earned' => $points];
            } else {
                return $update_result;
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'حدث خطأ: ' . $e->getMessage()];
        }
    }

    public function exchangeForMoney($user_id, $material_type, $quantity) {
        try {
            $points = $this->calculatePoints($material_type, $quantity);
            if ($points <= 0) return ['success' => false, 'message' => 'الكمية غير كافية للتبديل'];
            
            $money = ($points / 100) * 10;
            $result = $this->addMaterial($material_type, $quantity);
            if (!$result['success']) return $result;
            
            require_once 'User.php';
            $user = new User();
            $update_result = $user->updateBalance($user_id, $money);
            
            if ($update_result['success']) {
                return ['success' => true, 'message' => 'تم التبديل بنجاح', 'money_earned' => $money];
            } else {
                return $update_result;
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'حدث خطأ: ' . $e->getMessage()];
        }
    }
    
    public function getAllMaterials() {
        try {
            $sql = "SELECT * FROM material ORDER BY material_id DESC";
            $stmt = $this->db->query($sql, []);
            return $this->db->fetchAll($stmt);
        } catch (Exception $e) {
            return [];
        }
    }
    
    public function getMaterial($material_id) {
        try {
            $sql = "SELECT * FROM material WHERE material_id = :material_id";
            $stmt = $this->db->query($sql, [':material_id' => $material_id]);
            return $this->db->fetchOne($stmt);
        } catch (Exception $e) {
            return null;
        }
    }
    
    private function getNextMaterialId() {
        $sql = "SELECT COALESCE(MAX(material_id), 0) + 1 as next_id FROM material";
        $stmt = $this->db->query($sql, []);
        $result = $this->db->fetchOne($stmt);
        return $result['NEXT_ID'];
    }
    
    private function generateQRCode() {
        return rand(100000000, 999999999);
    }
    
    public function getConversionRates() {
        return $this->conversion_rates;
    }
}
?>