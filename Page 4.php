<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تفاصيل بدل الخردة</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Page 4.css">
    <link rel="stylesheet" href="Navbar.css">
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

        <div class="col-lg-6 left-section">
            <h4 class="note-head">ابدأ الهدف الآن</h4>

            <div class="goal-box">
                <label>العدد المحدد</label>
                <input type="number" id="bottleCount" oninput="calculatePoints()" placeholder="0">

                <label>النقاط بعد التبديل</label>
                <input type="text" id="pointsResult" readonly placeholder="0">

                <button onclick="startGoal()" class="btn-start">ابدأ</button>
            </div>
        </div>

    </div>
</div>

<script>
function calculatePoints() {
    let n = parseInt(document.getElementById('bottleCount').value) || 0;
    document.getElementById('pointsResult').value = Math.floor(n / 20) * 100;
}

function startGoal() {
    const bottles = parseInt(document.getElementById('bottleCount').value);
    const points  = parseInt(document.getElementById('pointsResult').value);

    if (points <= 0) {
        alert("أدخل 20 زجاجة على الأقل");
        return;
    }

    fetch('set_goal.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        credentials: 'same-origin',
        body: JSON.stringify({ bottles, points })
    })
    .then(r => r.json())
    .then(d => {
        if (d.success) {
            window.location.href = 'Page 5.php';
        } else {
            alert(d.message);
        }
    });
}
</script>

</body>
</html>
