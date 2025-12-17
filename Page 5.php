<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'], $_SESSION['goal'])) {
    header("Location: Page 4.php");
    exit;
}

$goal = $_SESSION['goal'];
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

<div class="container mt-5 py-5">
    <div class="row align-items-center">

        <div class="col-md-6 text-center">
            <h1 class="display-3 fw-bold mb-5">تتبع التبديل</h1>

            <div class="counter-box d-flex align-items-center justify-content-center gap-5 mb-5">
                <button class="btn-counter" onclick="change(-1)">-</button>
                <span id="counter" class="counter-value">0</span>
                <button class="btn-counter" onclick="change(1)">+</button>
            </div>

            <div class="d-grid gap-3 col-8 mx-auto">
                <button class="btn-action" onclick="finishGoal()">
                    إنهاء الهدف وإضافة النقاط
                </button>
            </div>
        </div>

        <div class="col-md-6 text-center">
            <div class="circular-progress">
                <div class="inner-circle">
                    <img src="photo/Page5Photo.png" alt="Bottle">
                </div>
            </div>
            <div class="mt-3 fw-bold">
                بلاستيك<br>
                <?php echo $goal['bottles']; ?> زجاجة
            </div>
        </div>

    </div>
</div>

<script>
let count = 0;
const max = <?php echo (int)$goal['bottles']; ?>;

function change(v) {
    count += v;
    if (count < 0) count = 0;
    if (count > max) count = max;
    document.getElementById('counter').innerText = count;
}

function finishGoal() {
    if (count < max) {
        alert("لسه ما خلصتش الهدف");
        return;
    }

    fetch('finish_goal.php', {
        method: 'POST',
        credentials: 'same-origin'
    })
    .then(res => res.text()) 
    .then(text => {
        try {
            const data = JSON.parse(text);

            if (data.success) {
                alert("تم إضافة النقاط ✅");
                window.location.href = 'home.php';
            } else {
                alert(data.message || 'حدث خطأ');
            }
        } catch (e) {
            console.error(text);
            alert('خطأ غير متوقع (راجع Console)');
        }
    });
}
</script>


</body>
</html>
