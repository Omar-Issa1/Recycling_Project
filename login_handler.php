<?php
require_once 'config.php';
require_once 'User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $_SESSION['error'] = 'الرجاء ملء جميع الحقول';
        redirect('Page7.php');
    }

    $user = new User();
    $result = $user->login($username, $password);

    if ($result['success']) {
        redirect('home.php');
    } else {
        $_SESSION['error'] = $result['message'];
        redirect('Page7.php');
    }

} else {
    redirect('Page7.php');
}
