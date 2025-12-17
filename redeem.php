<?php
require_once 'config.php';
require_once 'User.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'يجب تسجيل الدخول']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$type   = $data['type'] ?? '';
$amount = (int) ($data['amount'] ?? 0);

if ($amount <= 0) {
    echo json_encode(['success' => false, 'message' => 'قيمة غير صالحة']);
    exit;
}

if ($amount > $_SESSION['points']) {
    echo json_encode(['success' => false, 'message' => 'نقاطك غير كافية']);
    exit;
}

$user = new User();


if ($type === 'points') {
    $user->updatePoints($_SESSION['user_id'], -$amount);

} elseif ($type === 'money') {
    $money = ($amount / 100) * 10;
    $user->updatePoints($_SESSION['user_id'], -$amount);
    $user->updateBalance($_SESSION['user_id'], $money);

} else {
    echo json_encode(['success' => false, 'message' => 'عملية غير معروفة']);
    exit;
}

echo json_encode([
    'success' => true,
    'points'  => $_SESSION['points'],
    'balance' => $_SESSION['balance']
]);
