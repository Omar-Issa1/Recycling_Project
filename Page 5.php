<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: Page7.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تتبع التبديل</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Page 5.css">
    <link rel="stylesheet" href="Navbar.css">
</head>
<body>

<?php include 'Navbar.php'; ?>

<div class="container mt-5 py-5 text-center">

    <h2 class="mb-4">رصيدك الحالي</h2>
    <h1 class="text-success mb-5">
        <?php echo (int) $_SESSION['points']; ?> نقطة
    </h1>

    <div class="counter-box d-flex justify-content-center align-items-center gap-4 mb-4">
        <button class="btn btn-danger" onclick="change(-100)">-</button>
        <span id="counter" class="fs-1 fw-bold">0</span>
        <button class="btn btn-success" onclick="change(100)">+</button>
    </div>

    <p class="mb-4">كل 100 نقطة = 10 جنيه</p>

    <div class="d-grid gap-3 col-6 mx-auto">
        <button class="btn btn-primary" onclick="redeem('points')">
            تثبيت التبديل بالنقاط
        </button>
        <button class="btn btn-warning" onclick="redeem('money')">
            تحويل النقاط لأموال
        </button>
    </div>
</div>

<script>
let counter = 0;
const maxPoints = <?php echo (int) $_SESSION['points']; ?>;

function change(value) {
    counter += value;
    if (counter < 0) counter = 0;
    if (counter > maxPoints) counter = maxPoints;
    document.getElementById('counter').innerText = counter;
}

function redeem(type) {
    if (counter <= 0) {
        alert("اختر عدد نقاط صحيح");
        return;
    }

    fetch('redeem.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            type: type,
            amount: counter
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("تمت العملية بنجاح ✅");
            location.reload();
        } else {
            alert(data.message);
        }
    });
}
</script>

</body>
</html>
