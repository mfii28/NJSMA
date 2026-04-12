<?php
require_once __DIR__ . '/../src/init.php';
if (empty($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }

$db = \Core\Database::getInstance();
$msg = $_GET['msg'] ?? '';
$action = $_GET['action'] ?? 'list';
$viewId = (int)($_GET['id'] ?? 0);
$item = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formAction = $_POST['form_action'] ?? '';
    if ($formAction === 'delete') {
        $db->execute("DELETE FROM tblmessages WHERE id=:id", ['id' => (int)$_POST['delete_id']]);
        header('Location: messages-manage.php?msg=' . urlencode('Message deleted.')); exit;
    }
    if ($formAction === 'mark_read') {
        $db->execute("UPDATE tblmessages SET Status='Read' WHERE id=:id", ['id' => (int)$_POST['id']]);
        header('Location: messages-manage.php?id='.$_POST['id'].'&action=view'); exit;
    }
}

if ($action === 'view' && $viewId) {
    $item = $db->fetch("SELECT * FROM tblmessages WHERE id=:id", ['id' => $viewId]);
}

$messages = $db->fetchAll("SELECT * FROM tblmessages ORDER BY CreatedAt DESC");
$currentPage = 'Citizen Portal Messages';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><title>Manage Messages – NJSMA Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
  <?php include __DIR__ . '/partials/sidebar.php'; ?>
  <div class="adm-main">
    <?php include __DIR__ . '/partials/header.php'; ?>
    <div class="adm-content">
      <?php if ($msg): ?><div class="adm-alert adm-alert-success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>

      <?php if ($action === 'view' && $item): ?>
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="fw-bold">View Message</h5></div>
        <a href="messages-manage.php" class="adm-btn adm-btn-outline">Back</a>
      </div>
      <div class="adm-card p-4">
        <div class="row mb-4">
          <div class="col-md-6">
            <label class="adm-form-label text-muted">From</label>
            <div class="fw-bold fs-5"><?= htmlspecialchars($item['SenderName']) ?></div>
            <div class="text-primary small"><?= htmlspecialchars($item['SenderEmail']) ?> | <?= htmlspecialchars($item['SenderPhone']) ?></div>
          </div>
          <div class="col-md-6 text-md-end">
            <label class="adm-form-label text-muted">Date Received</label>
            <div><?= date('F j, Y, g:i a', strtotime($item['CreatedAt'])) ?></div>
            <span class="adm-badge <?= $item['Status']==='Unread' ? 'adm-badge-danger' : 'adm-badge-success' ?>"><?= $item['Status'] ?></span>
          </div>
        </div>
        <div class="mb-4">
          <label class="adm-form-label text-muted">Subject & Type</label>
          <div class="fw-bold">[<?= $item['Type'] ?>] <?= htmlspecialchars($item['Subject']) ?></div>
        </div>
        <hr>
        <div class="p-3 bg-light rounded" style="white-space: pre-wrap; font-size: 15px;"><?= htmlspecialchars($item['Message']) ?></div>

        <div class="mt-4 d-flex gap-2">
          <?php if($item['Status']==='Unread'): ?>
          <form method="POST"><input type="hidden" name="form_action" value="mark_read"><input type="hidden" name="id" value="<?= $item['id'] ?>"><button type="submit" class="adm-btn adm-btn-primary">Mark as Read</button></form>
          <?php endif; ?>
          <a href="mailto:<?= $item['SenderEmail'] ?>?subject=Re: <?= urlencode($item['Subject']) ?>" class="adm-btn adm-btn-outline"><i class="bi bi-reply me-1"></i> Reply via Email</a>
        </div>
      </div>
      <?php else: ?>
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="fw-bold">Citizen Portal Inbox</h5></div>
      </div>
      <div class="adm-card p-0">
        <table class="adm-table w-100">
          <thead><tr><th>#</th><th>Date</th><th>Sender</th><th>Subject / Type</th><th>Status</th><th>Actions</th></tr></thead>
          <tbody>
            <?php foreach ($messages as $i => $row): ?>
            <tr class="<?= $row['Status']==='Unread' ? 'fw-bold bg-light' : '' ?>">
              <td><?= $i+1 ?></td>
              <td><?= date('M d, Y', strtotime($row['CreatedAt'])) ?></td>
              <td><?= htmlspecialchars($row['SenderName']) ?></td>
              <td><span class="text-muted small">[<?= $row['Type'] ?>]</span> <?= htmlspecialchars($row['Subject']) ?></td>
              <td><span class="adm-badge <?= $row['Status']==='Unread' ? 'adm-badge-danger' : 'adm-badge-success' ?>"><?= $row['Status'] ?></span></td>
              <td>
                <a href="messages-manage.php?action=view&id=<?= $row['id'] ?>" class="adm-btn adm-btn-sm adm-btn-outline">View</a>
                <form method="POST" class="d-inline" onsubmit="return confirm('Delete?');"><input type="hidden" name="form_action" value="delete"><input type="hidden" name="delete_id" value="<?= $row['id'] ?>"><button type="submit" class="adm-btn adm-btn-sm adm-btn-danger">Delete</button></form>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php if(empty($messages)): ?><tr><td colspan="6" class="text-center py-5 text-muted">No messages yet.</td></tr><?php endif; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
