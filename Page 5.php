<?php
require_once 'config.php';

if (!isLoggedIn() || !isset($_SESSION['goal'])) {
    redirect('Page 4.php');
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

    <h3 class="mb-3">هدفك الحالي</h3>
    <p>عدد الزجاجات: <strong><?= $goal['bottles'] ?></strong></p>
    <p>النقاط المتوقعة: <strong><?= $goal['points'] ?></strong></p>

    <hr>

    <h4>عدد الزجاجات التي أضفتها</h4>

    <div class="d-flex justify-content-center align-items-center gap-4 my-4">
        <button class="btn btn-danger" onclick="change(-1)">-</button>
        <span id="count" class="fs-2"><?= $goal['done'] ?></span>
        <button class="btn btn-success" onclick="change(1)">+</button>
    </div>

    <button class="btn btn-primary"
            onclick="finishGoal()"
            <?= $goal['done'] < $goal['bottles'] ? 'disabled' : '' ?>>
        إنهاء الهدف وإضافة النقاط
    </button>

</div>

<script>
let done = <?= $goal['done'] ?>;
const max = <?= $goal['bottles'] ?>;

function change(v) {
    done += v;
    if (done < 0) done = 0;
    if (done > max) done = max;
    document.getElementById('count').innerText = done;
}

function finishGoal() {
    fetch('finish_goal.php', {
        method: 'POST'
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("تم إضافة النقاط بنجاح ✅");
            location.reload();
        } else {
            alert(data.message);
        }
    });
}
</script>

</body>
</html>
