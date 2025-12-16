<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="ar">

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

  <div class="auth-card">
    <label>اسم المستخدم</label>
    <input type="text">

    <label>كلمة المرور</label>
    <input type="password">

    <a href="#" class="forgot">هل نسيت كلمة المرور؟</a>

    <button  class="btn btn-success w-100 mt-3" onclick="window.location.href='Page 2.php'">سجل الدخول</button>

    <div class="separator">
      <span></span>
      <p>طرق تسجيل أخرى</p>
      <span></span>
    </div>

    <button class="social google">
      <img src="photo/google.svg"> Google
    </button>

    <button class="social facebook">
      <img src="photo/Facebook.svg"> Facebook
    </button>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
