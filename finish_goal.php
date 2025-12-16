<?php
require_once 'config.php';
require_once 'User.php';

if (!isset($_SESSION['user_id'], $_SESSION['goal'])) {
    echo json_encode(['success' => false]);
    exit;
}

$user = new User();
$user->updatePoints($_SESSION['user_id'], $_SESSION['goal']['points']);

unset($_SESSION['goal']);

echo json_encode(['success' => true]);
