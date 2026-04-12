<?php
require_once __DIR__ . '/../src/init.php';
if (empty($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }

$db = \Core\Database::getInstance();
$msg = '';
$action = $_GET['action'] ?? 'list';
$editId = (int)($_GET['id'] ?? 0);
$item = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formAction = $_POST['form_action'] ?? '';

    if ($formAction === 'save') {
        $title = trim($_POST['Title'] ?? '');
        $year  = (int)($_POST['ReportYear'] ?? date('Y'));
        $cat   = $_POST['Category'] ?? '';
        $desc  = $_POST['Description'] ?? '';
        $id    = (int)($_POST['id'] ?? 0);

        // File upload
        $file = $_POST['existing_file'] ?? '';
        if (!empty($_FILES['BudgetFile']['name'])) {
            $ext = pathinfo($_FILES['BudgetFile']['name'], PATHINFO_EXTENSION);
            $file = 'budget_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['BudgetFile']['tmp_name'], ROOT_PATH . '/docs/' . $file);
        }

        if ($id) {
            $db->execute("UPDATE tblbudgets SET Title=:t, ReportYear=:y, Category=:c, Description=:d, FilePath=:f WHERE id=:id",
                ['t'=>$title, 'y'=>$year, 'c'=>$cat, 'd'=>$desc, 'f'=>$file, 'id'=>$id]);
            $msg = 'Budget updated!';
        } else {
            $db->execute("INSERT INTO tblbudgets (Title, ReportYear, Category, Description, FilePath) VALUES (:t,:y,:c,:d,:f)",
                ['t'=>$title, 'y'=>$year, 'c'=>$cat, 'd'=>$desc, 'f'=>$file]);
            $msg = 'Budget added!';
        }
        header('Location: budgets-manage.php?msg=' . urlencode($msg)); exit;
    }

    if ($formAction === 'delete') {
        $db->execute("DELETE FROM tblbudgets WHERE id=:id", ['id' => (int)$_POST['delete_id']]);
        header('Location: budgets-manage.php?msg=' . urlencode('Budget deleted.')); exit;
    }
}

if ($action === 'edit' && $editId) {
    $item = $db->fetch("SELECT * FROM tblbudgets WHERE id=:id", ['id' => $editId]);
}

if (isset($_GET['msg'])) $msg = $_GET['msg'];
$budgets = $db->fetchAll("SELECT * FROM tblbudgets ORDER BY ReportYear DESC, Category ASC");
$currentPage = 'Budgets & Finance';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><title>Manage Budgets – NJSMA Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
  <?php include __DIR__ . '/partials/sidebar.php'; ?>
  <div class="adm-main">
    <?php include __DIR__ . '/partials/header.php'; ?>
    <div class="adm-content">
      <?php if ($msg): ?><div class="adm-alert adm-alert-success"><i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars($msg) ?></div><?php endif; ?>

      <?php if ($action === 'new' || $action === 'edit'): ?>
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="fw-bold"><?= $item ? 'Edit Budget/Report' : 'New Budget/Report' ?></h5></div>
        <a href="budgets-manage.php" class="adm-btn adm-btn-outline">Back</a>
      </div>
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="form_action" value="save">
        <input type="hidden" name="id" value="<?= $item['id'] ?? '' ?>">
        <input type="hidden" name="existing_file" value="<?= $item['FilePath'] ?? '' ?>">
        <div class="row g-3">
          <div class="col-lg-8">
            <div class="adm-card p-4">
              <div class="mb-3"><label class="adm-form-label">Report Title *</label><input type="text" name="Title" class="adm-form-control" required value="<?= $item['Title'] ?? '' ?>"></div>
              <div class="mb-0"><label class="adm-form-label">Description (Optional)</label><textarea name="Description" rows="4" class="adm-form-control"><?= $item['Description'] ?? '' ?></textarea></div>
            </div>
          </div>
          <div class="col-lg-4 d-flex flex-column gap-3">
            <div class="adm-card p-4">
              <div class="mb-3"><label class="adm-form-label">Year</label><input type="number" name="ReportYear" class="adm-form-control" value="<?= $item['ReportYear'] ?? date('Y') ?>"></div>
              <div class="mb-3"><label class="adm-form-label">Category</label><select name="Category" class="adm-form-control" required>
                <?php foreach(['Composite Budget','PBB','IGF Report','Financial Statement','Audit Report'] as $c): ?>
                <option value="<?= $c ?>" <?= ($item['Category'] ?? '') === $c ? 'selected' : '' ?>><?= $c ?></option>
                <?php endforeach; ?>
              </select></div>
              <div class="mb-3"><label class="adm-form-label">PDF File</label><input type="file" name="BudgetFile" class="adm-form-control" accept=".pdf"></div>
              <button type="submit" class="adm-btn adm-btn-primary w-100">Save Budget</button>
            </div>
          </div>
        </div>
      </form>
      <?php else: ?>
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="fw-bold">Budgets & Financial Reports</h5></div>
        <a href="budgets-manage.php?action=new" class="adm-btn adm-btn-primary">+ Add New</a>
      </div>
      <div class="adm-card p-0">
        <table class="adm-table w-100">
          <thead><tr><th>#</th><th>Title</th><th>Year</th><th>Category</th><th>File</th><th>Actions</th></tr></thead>
          <tbody>
            <?php foreach ($budgets as $i => $row): ?>
            <tr>
              <td><?= $i+1 ?></td>
              <td class="fw-bold"><?= htmlspecialchars($row['Title']) ?></td>
              <td><?= $row['ReportYear'] ?></td>
              <td><span class="adm-badge adm-badge-info"><?= $row['Category'] ?></span></td>
              <td><a href="<?= SITE_URL ?>/docs/<?= $row['FilePath'] ?>" target="_blank" class="text-primary"><i class="bi bi-file-pdf"></i> View File</a></td>
              <td>
                <a href="budgets-manage.php?action=edit&id=<?= $row['id'] ?>" class="adm-btn adm-btn-sm adm-btn-outline">Edit</a>
                <form method="POST" class="d-inline" onsubmit="return confirm('Delete?');"><input type="hidden" name="form_action" value="delete"><input type="hidden" name="delete_id" value="<?= $row['id'] ?>"><button type="submit" class="adm-btn adm-btn-sm adm-btn-danger">Delete</button></form>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
