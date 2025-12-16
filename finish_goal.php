<?php
require_once 'config.php';
require_once 'User.php';

if (!isLoggedIn() || !isset($_SESSION['goal'])) {
    echo json_encode(['success' => false]);
    exit;
}

$goal = $_SESSION['goal'];

if ($goal['done'] < $goal['bottles']) {
    echo json_encode(['success' => false, 'message' => 'الهدف لم يكتمل']);
    exit;
}

$user = new User();
$user->updatePoints($_SESSION['user_id'], $goal['points']);

unset($_SESSION['goal']);

echo json_encode(['success' => true]);
