<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل بدل الخردة</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="Page 4.css">
<link rel="stylesheet" href="Navbar.css">
    <link rel="website icon" href="photo/Icon.png" type="png">
</head>
<body>
    <?php include 'Navbar.php'; ?>

    <div class="container main-container">
        <div class="row align-items-start">
            <div class="col-lg-6 right-section">
                
                <div class="img-frame">
                    <img src="photo/Photo 1.png" alt="بلاستيك">
                </div>

                <div class="materials-list">
                    <h2 class="section-title">البلاستيك المستخدم</h2>
                    <ul>
                        <li><span class="dot"></span> بلاستيك المواد الغازية</li>
                        <li><span class="dot"></span> بلاستيك المعلبات</li>
                        <li><span class="dot"></span> المواد البلاستيكية الأخرى</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 left-section">
                <h4 class="note-head">ملاحظات هامة عن الخردة قبل التبديل</h4>
                <div class="note-box">
                    <ul>
                        <li><i class="fa-solid fa-check"></i> متاح تبديلها من أي مكان</li>
                        <li><i class="fa-solid fa-check"></i> خصومات و عروض فقط</li>
                        <li><i class="fa-solid fa-check"></i> لكل 20 زجاجة 100 نقطة</li>
                        <li><i class="fa-solid fa-check"></i> يرجى فرز المواد الصحيحة</li>
                    </ul>
                </div>
                <div class="goal-wrapper">
                    <h4 class="goal-head">ابدأ الهدف الآن</h4>
                    
                    <div class="goal-box">
                        <label>العدد المحدد</label>
                        <input type="number" id="bottleCount" oninput="calculatePoints()" placeholder="0">

                        <label>العملات بعد التبديل</label>
                        <input type="text" id="pointsResult" readonly placeholder="0">

                        <button onclick="startGoal()" class="btn-start">ابدأ</button>
                    </div>
                </div>

            </div>

        </div>
    </div>
        <script>
    function calculatePoints() {
        let count = document.getElementById('bottleCount').value;
        let resultInput = document.getElementById('pointsResult');
        let n = parseInt(count);

        if (isNaN(n) || n < 0) n = 0;

        let points = Math.floor(n / 20) * 100;
        resultInput.value = points;
    }

    function startGoal() {
    let points = parseInt(document.getElementById('pointsResult').value);

    if (points > 0) {
        fetch('add_points.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ points: points })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("تم إضافة " + points + " نقطة بنجاح ✅");
                window.location.href = "Page 5.php";
            } else {
                alert(data.message);
            }
        });
    } else {
        alert("أدخل 20 زجاجة على الأقل");
    }
}
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>