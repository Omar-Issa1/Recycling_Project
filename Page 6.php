<?php
require_once 'config.php';

if (isLoggedIn()) {
    redirect('Page 1.php');
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>إنشاء حساب جديد</title>
  <link rel="stylesheet" href="Register.css">
  <link rel="stylesheet" href="Nav Register.css">
  <link rel="website icon" href="photo/Icon.png" type="png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'Nav Register.php'; ?>

<div class="page-wrapper">

  <h1 class="auth-title">إنشاء حساب جديد</h1>

  <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger" role="alert" style="max-width: 420px; margin: 10px auto;">
      <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
  <?php endif; ?>

  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success" role="alert" style="max-width: 420px; margin: 10px auto;">
      <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
  <?php endif; ?>

  <div class="auth-card">
    <form action="register_handler.php" method="POST">
      <label>اسم المستخدم</label>
      <input type="text" name="username" placeholder="يرجى إدخال اسم مستخدم غير مستخدم من قبل" required>

      <label>البريد الإلكتروني</label>
      <input type="email" name="email" placeholder="Example123@gmail.com" required>

      <label>رقم الهاتف</label>
      <input type="text" name="phone" placeholder="01xxxxxxxxx">

      <label>العنوان</label>
      <input type="text" name="address" placeholder="المحافظة، المدينة">

      <label>كلمة المرور</label>
      <input type="password" name="password" placeholder="******" required>

      <button type="submit" class="btn btn-success w-100 mt-3">انضم الآن</button>
    </form>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>