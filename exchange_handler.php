<?php
require_once 'config.php';
require_once 'Material.php';
// check login
if (!isLoggedIn()) {
    $_SESSION['error'] = 'يجب تسجيل الدخول أولاً';
    redirect('Page 7.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $material_type = sanitize($_POST['material_type']);
    $quantity = intval($_POST['quantity']);
    $exchange_type = sanitize($_POST['exchange_type']); // 'points' or 'money'
    $user_id = $_SESSION['user_id'];
    
    if (empty($material_type) || $quantity <= 0) {
        $_SESSION['error'] = 'الرجاء إدخال بيانات صحيحة';
        redirect('Page 4.php');
    }
    
    $material = new Material();
    
    if ($exchange_type == 'points') {
        $result = $material->exchangeForPoints($user_id, $material_type, $quantity);
    } else if ($exchange_type == 'money') {
        $result = $material->exchangeForMoney($user_id, $material_type, $quantity);
    } else {
        $_SESSION['error'] = 'نوع التبديل غير صحيح';
        redirect('Page 4.php');
    }
    
    if ($result['success']) {
        if ($exchange_type == 'points') {
            $_SESSION['success'] = 'تم التبديل بنجاح! لقد حصلت على ' . $result['points_earned'] . ' نقطة';
        } else {
            $_SESSION['success'] = 'تم التبديل بنجاح! لقد حصلت على ' . $result['money_earned'] . ' جنيه';
        }
        redirect('Page 5.php');
    } else {
        $_SESSION['error'] = $result['message'];
        redirect('Page 4.php');
    }
} else {
    redirect('Page 4.php');
}
?>