<?php require_once 'config.php'; ?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>بدل الخردة</title>
<link rel="website icon" href="photo/Icon.png" type="png">
<link rel="stylesheet" href="Navbar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="Page 3.css">
</head>

<body>

<?php include 'Navbar.php'; ?>

<section class="container my-5">
    <div class="row justify-content-center g-4">
        <div class="col-md-4">
            <div class="card-custom">
                <img src="photo/Photo 3.png">
                <h4>الإلكترونيات</h4>
                <ul>
                    <li>100 نقطة لكل 20 قطعة</li>
                    <li>خصومات و عروض فقط</li>
                    <li>متاح تبديلها من المنزل</li>
                </ul>
                <button class="btn btn-success w-100">غير متاح</button>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-custom">
                <img src="photo/Photo 2.png">
                <h4>الصفيح (الكانز)</h4>
                <ul>
                    <li>700 نقطة لكل 20 قطعة</li>
                    <li>خصومات و عروض فقط</li>
                    <li>متاح تبديلها من المنزل</li>
                </ul>
                <button class="btn btn-success w-100">غير متاح</button>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-custom">
                <img src="photo/Photo 1.png">
                <h4>البلاستيك المستخدم</h4>
                <ul>
                    <li>100 نقطة لكل 20 زجاجة</li>
                    <li>خصومات و عروض فقط</li>
                    <li>متاح تبديلها من أي مكان</li>
                </ul>
                <button onclick="window.location.href='Page 4.php'" class="btn btn-success w-100">ابدا الان</button>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
