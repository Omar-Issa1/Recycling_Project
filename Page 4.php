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
                    <li>بلاستيك المواد الغازية</li>
                    <li>بلاستيك المعلبات</li>
                    <li>مواد بلاستيكية أخرى</li>
                </ul>
            </div>
        </div>

        <div class="col-lg-6 left-section">
            <h4 class="note-head">ابدأ الهدف الآن</h4>

            <div class="goal-box">
                <label>عدد الزجاجات</label>
                <input type="number" id="bottleCount" oninput="calculatePoints()" value="0">

                <label>النقاط المتوقعة</label>
                <input type="text" id="pointsResult" readonly value="0">

                <button onclick="startGoal()" class="btn-start">
                    بدء الهدف
                </button>
            </div>
        </div>

    </div>
</div>

<script>
function calculatePoints() {
    const bottles = parseInt(document.getElementById('bottleCount').value) || 0;
    const points  = Math.floor(bottles / 20) * 100;
    document.getElementById('pointsResult').value = points;
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
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            window.location.href = 'Page 5.php';
        } else {
            alert(data.message);
        }
    });
}
</script>

</body>
</html>
