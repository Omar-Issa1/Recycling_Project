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
    <title>تنفيذ الهدف</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="Page 5.css">
    <link rel="stylesheet" href="Navbar.css">
</head>

<body>

<?php include 'Navbar.php'; ?>

<div class="container text-center mt-5">

    <h3>هدفك الحالي</h3>
    <p>عدد الزجاجات: <strong><?php echo $goal['bottles']; ?></strong></p>
    <p>النقاط عند الإنهاء: <strong><?php echo $goal['points']; ?></strong></p>

    <h1 id="counter" class="my-4">0</h1>

    <div class="d-flex justify-content-center gap-3">
        <button class="btn btn-success" onclick="addBottle()">+ زجاجة</button>
        <button class="btn btn-danger" onclick="finishGoal()">إنهاء الهدف</button>
    </div>

</div>

<script>
let collected = 0;
const goalBottles = <?php echo $goal['bottles']; ?>;

function addBottle() {
    if (collected < goalBottles) {
        collected++;
        document.getElementById('counter').innerText = collected;
    }
}

function finishGoal() {
    if (collected < goalBottles) {
        alert("لسه ما خلصتش الهدف");
        return;
    }

    fetch('finish_goal.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        credentials: 'same-origin'
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("تم إنهاء الهدف وإضافة النقاط ✅");
            location.href = 'home.php';
        } else {
            alert(data.message);
        }
    });
}
</script>

</body>
</html>
