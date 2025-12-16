<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> الرئيسية</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="/home.css">
    <link rel="website icon" href="photo/Icon.png" type="png">
<link rel="stylesheet" href="Navbar.css">
</head>
<body>
    <?php include 'Navbar.php'; ?>
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 order-2 order-md-1 text-center text-md-end">
                    <h1 class="hero-title">بدل الخردة بنقط و فلوس من بيتك !</h1>
                    
                    <ul class="features-list">
                        <li><i class="fas fa-check-circle"></i> أمن و سهل في الاستخدام</li>
                        <li><i class="fas fa-check-circle"></i> نقاط و جوائز مجزية علي تبديل الخردة</li>
                        <li><i class="fas fa-check-circle"></i> متوفر في جميع محافظات مصر</li>
                    </ul>

                    <div class="d-flex flex-column align-items-md-start align-items-center">
                        <button onclick="window.location.href='Page7.php'" class="hero-btn-start">إبدأ دلوقتي !</button>
                        <button onclick="window.location.href='Page6.php'" class="hero-btn-join">إنضم لفريق عمل خردة الان</button>
                    </div>
                </div>

                <div class="col-md-6 order-1 order-md-2 mb-4 mb-md-0 text-center">
                    <img src="photo/Page1Photo.png" alt="Recycling Globe" class="globe-img">
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>