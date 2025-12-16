<?php
if (!isset($_SESSION)) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
?>
<nav class="navbar-frame">
    <div class="navbar container">
        <div class="nav-logo">
            <img src="photo/Logo.png" alt="خردة">
        </div>
        <ul class="nav-links">
            <li><a href="home.php">الرئيسية</a></li>
            <li><a href="Page 2.php">الخدمات</a></li>
            <li><a href="Page 3.php">بدل الخردة</a></li>
            <li><a href="Page 4.php">النقاط والجوائز</a></li>
            <li><a href="#">الدعم الفني</a></li>
        </ul>
        
        <div class="nav-actions">
            <?php if ($isLoggedIn): ?>
                <div class="d-flex align-items-center gap-2">
                    <span class="text-success fw-bold"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <span class="badge bg-success"><?php echo $_SESSION['points']; ?> نقطة</span>
                    <button onclick="window.location.href='logout.php'" class="btn btn-outline-danger btn-sm">تسجيل خروج</button>
                    <div class="user-icon"><img src="photo/User Icon.png" alt="user icon"></div>
                </div>
            <?php else: ?>
                <button onclick="window.location.href='Page 7.php'" class="btn btn-outline-success">تسجيل دخول</button>
                <button onclick="window.location.href='Page 6.php'" class="btn btn-success">حساب جديد</button>
                <div class="user-icon"><img src="photo/User Icon.png" alt="user icon"></div>
            <?php endif; ?>
        </div>
    </div>
</nav>