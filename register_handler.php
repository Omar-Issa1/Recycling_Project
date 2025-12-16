<?php
require_once 'config.php';
require_once 'User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $phone = sanitize($_POST['phone']) ?? '';
    $address = sanitize($_POST['address']) ?? 'غير محدد';
    
    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['error'] = 'الرجاء ملء جميع الحقول المطلوبة';
        redirect('Page 6.php');
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'البريد الإلكتروني غير صحيح';
        redirect('Page 6.php');
    }
    
    if (strlen($password) < 6) {
        $_SESSION['error'] = 'كلمة المرور يجب أن تكون 6 أحرف على الأقل';
        redirect('Page 6.php');
    }
    
    $user = new User();
    
    $result = $user->register($username, $email, $password, $phone, $address);
    
    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
        redirect('Page 7.php');
    } else {
        $_SESSION['error'] = $result['message'];
        redirect('Page 6.php');
    }
} else {
    redirect('Page 6.php');
}
?>
