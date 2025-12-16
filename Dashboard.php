<?php
require_once 'dashboard_backend.php';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>لوحة تحكم الأدمن</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="Dashboard.css">
  <style>
    .stats-box {
      background: white;
      border: 2px solid #4f7f2f;
      border-radius: 20px;
      padding: 20px;
      margin-bottom: 20px;
      text-align: center;
    }
    .stats-box h3 {
      color: #4f7f2f;
      font-size: 2rem;
      font-weight: bold;
    }
    .stats-box p {
      color: #666;
      font-size: 1rem;
    }
  </style>
</head>

<body>

<div class="admin-wrapper">
  <h1 class="admin-title">لوحة تحكم الأدمن</h1>

  <!-- الإحصائيات -->
  <div class="row mb-4">
    <div class="col-md-3">
      <div class="stats-box">
        <h3><?php echo $statistics['total_users']; ?></h3>
        <p>عدد المستخدمين</p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stats-box">
        <h3><?php echo $statistics['total_points']; ?></h3>
        <p>إجمالي النقاط</p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stats-box">
        <h3><?php echo $statistics['total_balance']; ?></h3>
        <p>إجمالي الأرصدة</p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stats-box">
        <h3><?php echo $statistics['total_materials']; ?></h3>
        <p>المواد المعاد تدويرها</p>
      </div>
    </div>
  </div>

  <div class="admin-search">
    <input type="text" id="searchInput" placeholder="ابحث بالاسم أو البريد...">
  </div>

  <div class="admin-table-box">
    <table id="adminTable">
      <thead>
        <tr>
          <th>المعرف</th>
          <th>الاسم</th>
          <th>البريد الإلكتروني</th>
          <th>الهاتف</th>
          <th>الرصيد</th>
          <th>النقاط</th>
          <th>التحكم</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user): ?>
        <tr data-user-id="<?php echo $user['user_id']; ?>">
  <td><?php echo $user['user_id']; ?></td>
  <td class="username"><?php echo htmlspecialchars($user['username'] ?? ''); ?></td>
  <td class="email"><?php echo htmlspecialchars($user['user_email'] ?? ''); ?></td>
  <td class="phone"><?php echo htmlspecialchars($user['user_phone'] ?? ''); ?></td>
  <td class="balance"><?php echo $user['balance']; ?></td>
  <td class="points"><?php echo $user['points']; ?></td>
  <td>
    <button class="btn-action edit" onclick="editUser(<?php echo $user['user_id']; ?>)">تعديل</button>
    <button class="btn-action delete" onclick="deleteUser(<?php echo $user['user_id']; ?>)">حذف</button>
  </td>
</tr>

        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</div>

<!-- Modal للتعديل -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">تعديل بيانات المستخدم</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="editForm">
          <input type="hidden" id="edit_user_id">
          <div class="mb-3">
            <label class="form-label">اسم المستخدم</label>
            <input type="text" class="form-control" id="edit_username" required>
          </div>
          <div class="mb-3">
            <label class="form-label">البريد الإلكتروني</label>
            <input type="email" class="form-control" id="edit_email" required>
          </div>
          <div class="mb-3">
            <label class="form-label">رقم الهاتف</label>
            <input type="text" class="form-control" id="edit_phone">
          </div>
          <div class="mb-3">
            <label class="form-label">الرصيد</label>
            <input type="number" class="form-control" id="edit_balance" step="0.01">
          </div>
          <div class="mb-3">
            <label class="form-label">النقاط</label>
            <input type="number" class="form-control" id="edit_points">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
        <button type="button" class="btn btn-success" onclick="saveUser()">حفظ</button>
      </div>
    </div>
  </div>
</div>

<script>
// البحث
const searchInput = document.getElementById("searchInput");
const table = document.getElementById("adminTable");
const rows = table.getElementsByTagName("tr");

searchInput.addEventListener("keyup", function () {
  const filter = searchInput.value.toLowerCase();

  for (let i = 1; i < rows.length; i++) {
    let text = rows[i].innerText.toLowerCase();
    rows[i].style.display = text.includes(filter) ? "" : "none";
  }
});

// تعديل مستخدم
function editUser(userId) {
  const row = document.querySelector(`tr[data-user-id="${userId}"]`);
  
  document.getElementById('edit_user_id').value = userId;
  document.getElementById('edit_username').value = row.querySelector('.username').textContent;
  document.getElementById('edit_email').value = row.querySelector('.email').textContent;
  document.getElementById('edit_phone').value = row.querySelector('.phone').textContent;
  document.getElementById('edit_balance').value = row.querySelector('.balance').textContent;
  document.getElementById('edit_points').value = row.querySelector('.points').textContent;
  
  const modal = new bootstrap.Modal(document.getElementById('editModal'));
  modal.show();
}

// حفظ التعديلات
function saveUser() {
  const formData = new FormData();
  formData.append('action', 'update_user');
  formData.append('user_id', document.getElementById('edit_user_id').value);
  formData.append('username', document.getElementById('edit_username').value);
  formData.append('email', document.getElementById('edit_email').value);
  formData.append('phone', document.getElementById('edit_phone').value);
  formData.append('balance', document.getElementById('edit_balance').value);
  formData.append('points', document.getElementById('edit_points').value);
  
  fetch('dashboard_backend.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert(data.message);
      location.reload();
    } else {
      alert('خطأ: ' + data.message);
    }
  })
  .catch(error => {
    alert('حدث خطأ في الاتصال');
  });
}

// حذف مستخدم
function deleteUser(userId) {
  if (!confirm('هل أنت متأكد من حذف هذا المستخدم؟')) {
    return;
  }
  
  const formData = new FormData();
  formData.append('action', 'delete_user');
  formData.append('user_id', userId);
  
  fetch('dashboard_backend.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert(data.message);
      location.reload();
    } else {
      alert('خطأ: ' + data.message);
    }
  })
  .catch(error => {
    alert('حدث خطأ في الاتصال');
  });
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>