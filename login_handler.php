<?php
require_once 'config.php';
require_once 'User.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('Page7.php');
}

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username === '' || $password === '') {
    $_SESSION['error'] = 'املأ كل الحقول';
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
