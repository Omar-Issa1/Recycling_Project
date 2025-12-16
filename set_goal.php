<?php
require_once 'config.php';

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'يجب تسجيل الدخول']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$bottles = (int) ($data['bottles'] ?? 0);
$points  = (int) ($data['points'] ?? 0);

if ($bottles <= 0 || $points <= 0) {
    echo json_encode(['success' => false, 'message' => 'بيانات غير صالحة']);
    exit;
}

$_SESSION['goal'] = [
    'bottles' => $bottles,
    'points'  => $points,
    'done'    => 0
];

echo json_encode(['success' => true]);
