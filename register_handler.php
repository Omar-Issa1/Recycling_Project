<?php
require_once 'config.php';
require_once 'User.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('Page6.php');
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$email    = trim($_POST['email'] ?? '');
$phone    = trim($_POST['phone'] ?? '');
$address  = trim($_POST['address'] ?? '');

if ($username === '' || $password === '' || $email === '') {
    $_SESSION['error'] = 'الرجاء ملء الحقول المطلوبة';
    redirect('Page6.php');
}

$user = new User();
$result = $user->register($username, $password, $email, $phone, $address);

/*
  ⬇️ حماية 100%
  حتى لو register رجّعت حاجة ناقصة
*/
if (is_array($result) && isset($result['success']) && $result['success'] === true) {

    $_SESSION['success'] = $result['message'] ?? 'تم إنشاء الحساب بنجاح';
    redirect('Page7.php'); // صفحة تسجيل الدخول

} else {

    $_SESSION['error'] = $result['message'] ?? 'حدث خطأ أثناء إنشاء الحساب';
    redirect('Page6.php');
}
