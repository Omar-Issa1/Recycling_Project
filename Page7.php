<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تسجيل الدخول</title>
  <link rel="stylesheet" href="Register.css">
  <link rel="stylesheet" href="Nav Register.css">
  <link rel="website icon" href="photo/Icon.png" type="png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include 'Nav Register.php'; ?>

<div class="page-wrapper">

  <h1 class="auth-title">تسجيل الدخول للحساب</h1>

  <form class="auth-card" method="POST" action="login_handler.php">

    <label>اسم المستخدم</label>
    <input type="text" name="username" required>

    <label>كلمة المرور</label>
    <input type="password" name="password" required>

    <button type="submit" class="btn btn-success w-100 mt-3">
      سجل الدخول
    </button>

  </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
