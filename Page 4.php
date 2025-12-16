<?php
require_once 'config.php';

if (!isLoggedIn()) {
    redirect('Page7.php');
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تحديد الهدف</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="Page 4.css">
    <link rel="stylesheet" href="Navbar.css">
</head>
<body>

<?php include 'Navbar.php'; ?>

<div class="container main-container">
    <h3 class="text-center mb-4">حدد هدفك من البلاستيك</h3>

    <div class="goal-box mx-auto" style="max-width:400px">
        <label>عدد الزجاجات</label>
        <input type="number" id="bottleCount" class="form-control mb-3"
               oninput="calculatePoints()" min="0">

        <label>النقاط المتوقعة</label>
        <input type="text" id="pointsResult" class="form-control mb-3" readonly>

        <button onclick="startGoal()" class="btn btn-success w-100">
            ابدأ الهدف
        </button>
    </div>
</div>

<script>
function calculatePoints() {
    const n = parseInt(document.getElementById('bottleCount').value) || 0;
    const points = Math.floor(n / 20) * 100;
    document.getElementById('pointsResult').value = points;
}

function startGoal() {
    const bottles = parseInt(document.getElementById('bottleCount').value) || 0;
    const points  = parseInt(document.getElementById('pointsResult').value) || 0;

    if (bottles < 20 || points <= 0) {
        alert("الحد الأدنى 20 زجاجة");
        return;
    }

    fetch('set_goal.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            bottles: bottles,
            points: points
        })
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
