<?php
require_once 'config.php';
require_once 'User.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user_id'], $_SESSION['goal'])) {
    echo json_encode([
        'success' => false,
        'message' => 'الجلسة غير صالحة'
    ]);
    exit;
}

$user = new User();

$user->updatePoints(
    $_SESSION['user_id'],
    $_SESSION['goal']['points']
);

unset($_SESSION['goal']);

echo json_encode([
    'success' => true
]);
exit;
