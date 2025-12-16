<?php
require_once 'config.php';
require_once 'User.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'يجب تسجيل الدخول']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$points = (int) ($data['points'] ?? 0);

if ($points <= 0) {
    echo json_encode(['success' => false, 'message' => 'نقاط غير صالحة']);
    exit;
}

$user = new User();
$user->updatePoints($_SESSION['user_id'], $points);

echo json_encode(['success' => true]);
