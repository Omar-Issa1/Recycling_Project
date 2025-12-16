<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تتبع التبديل</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="Page 5.css">
    <link rel="website icon" href="photo/Icon.png" type="png">
<link rel="stylesheet" href="Navbar.css">
</head>
<body>
    <?php include 'Navbar.php'; ?>
    <div class="container mt-5 py-5">
        <div class="row align-items-center">
            <div class="col-md-6 text-center">
                <h1 class="display-3 fw-bold tracking-title mb-5">تتبع التبديل</h1>
                
                <div class="counter-box d-flex align-items-center justify-content-center gap-5 mb-5">
                    <button class="btn-counter">-</button>
                    <span class="counter-value">0</span>
                    <button class="btn-counter">+</button>
                </div>

                <div class="d-grid gap-3 col-8 mx-auto">
                    <button class="btn-action">بدل بنقاط الان</button>
                    <button class="btn-action">بدل بأموال الان</button>
                </div>
            </div>
            <div class="col-md-6 text-center">
                <div class="circular-progress">
                    <div class="inner-circle">
                        <img src="photo/image.png" alt="Bottle">
                    </div>
                </div>
                <div class="mt-3 fw-bold">بلاستيك<br>100%</div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const counterValue = document.querySelector('.counter-value');
    const btns = document.querySelectorAll('.btn-counter');

    let count = 0;

    btns.forEach(btn => {
        btn.addEventListener('click', () => {
            if(btn.textContent === '+') {
                count++;
            } else {
                count--;
                if(count < 0) count = 0;
            }
            counterValue.textContent = count;
        });
    });
    const actionButtons = document.querySelectorAll('.btn-action');

    actionButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            if(btn.textContent.includes('نقاط')) {
                alert('تم اختيار استبدال النقاط! 🎉 حافظ على جمع المزيد من النقاط.');
            } else if(btn.textContent.includes('أموال')) {
                alert('تم اختيار استبدال الأموال! 💰 شكرًا لاستخدامك التطبيق.');
            }
        });
    });
</script>


</body>
</html>