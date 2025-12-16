<?php
require_once 'config.php';
require_once 'User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = 'الرجاء ملء جميع الحقول';
        redirect('Page 7.php');
    }
    
    $user = new User();
    
    $result = $user->login($username, $password);
    
    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
        redirect('home.php');
    } else {
        $_SESSION['error'] = $result['message'];
        redirect('Page7.php');
    }
} else {
    redirect('Page7.php');
}
?>

