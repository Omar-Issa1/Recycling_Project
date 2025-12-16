<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'يجب تسجيل الدخول']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$_SESSION['goal'] = [
    'bottles' => (int) $data['bottles'],
    'points'  => (int) $data['points'],
    'done'    => 0
];

echo json_encode(['success' => true]);
