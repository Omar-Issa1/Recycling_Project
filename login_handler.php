<?php
require_once 'config.php';
require_once 'User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $_SESSION['error'] = 'الرجاء ملء جميع الحقول';
        header('Location: Page7.php');
        exit;
    }

    $user = new User();
    $result = $user->login($username, $password);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
        header('Location: home.php');
        exit;
    } else {
        $_SESSION['error'] = $result['message'];
        header('Location: Page7.php');
        exit;
    }

} else {
    header('Location: Page7.php');
    exit;
}
