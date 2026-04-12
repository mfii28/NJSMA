<?php
require_once __DIR__ . '/../src/init.php';
if (empty($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }

$db = \Core\Database::getInstance();
$msg = $_GET['msg'] ?? '';
$action = $_GET['action'] ?? 'list';
$editId = (int)($_GET['id'] ?? 0);
$item = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formAction = $_POST['form_action'] ?? '';
    if ($formAction === 'save') {
        $q = trim($_POST['Question'] ?? '');
        $a = $_POST['Answer'] ?? '';
        $c = $_POST['Category'] ?? 'General';
        $o = (int)($_POST['DisplayOrder'] ?? 0);
        $id = (int)($_POST['id'] ?? 0);

        if ($id) {
            $db->execute("UPDATE tblfaqs SET Question=:q, Answer=:a, Category=:c, DisplayOrder=:o WHERE id=:id", ['q'=>$q, 'a'=>$a, 'c'=>$c, 'o'=>$o, 'id'=>$id]);
        } else {
            $db->execute("INSERT INTO tblfaqs (Question, Answer, Category, DisplayOrder) VALUES (:q,:a,:c,:o)", ['q'=>$q, 'a'=>$a, 'c'=>$c, 'o'=>$o]);
        }
        header('Location: faqs-manage.php?msg=FAQ saved!'); exit;
    }
    if ($formAction === 'delete') {
        $db->execute("DELETE FROM tblfaqs WHERE id=:id", ['id' => (int)$_POST['delete_id']]);
        header('Location: faqs-manage.php?msg=FAQ deleted!'); exit;
    }
}

if ($action === 'edit' && $editId) $item = $db->fetch("SELECT * FROM tblfaqs WHERE id=:id", ['id'=>$editId]);
$faqs = $db->fetchAll("SELECT * FROM tblfaqs ORDER BY Category, DisplayOrder ASC");
$currentPage = 'FAQs';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><title>Manage FAQs – NJSMA Admin</title>
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

      <?php if ($action === 'new' || $action === 'edit'): ?>
      <div class="d-flex justify-content-between align-items-center mb-4"><h5 class="fw-bold"><?= $item ? 'Edit FAQ' : 'Add FAQ' ?></h5><a href="faqs-manage.php" class="adm-btn adm-btn-outline">Back</a></div>
      <form method="POST">
        <input type="hidden" name="form_action" value="save"><input type="hidden" name="id" value="<?= $item['id'] ?? '' ?>">
        <div class="adm-card p-4">
          <div class="mb-3"><label class="adm-form-label">Question</label><input type="text" name="Question" class="adm-form-control" required value="<?= $item['Question'] ?? '' ?>"></div>
          <div class="mb-3"><label class="adm-form-label">Answer</label><textarea name="Answer" rows="5" class="adm-form-control" required><?= $item['Answer'] ?? '' ?></textarea></div>
          <div class="row">
            <div class="col-md-6 mb-3"><label class="adm-form-label">Category</label><input type="text" name="Category" class="adm-form-control" value="<?= $item['Category'] ?? 'General' ?>"></div>
            <div class="col-md-6 mb-3"><label class="adm-form-label">Display Order</label><input type="number" name="DisplayOrder" class="adm-form-control" value="<?= $item['DisplayOrder'] ?? 0 ?>"></div>
          </div>
          <button type="submit" class="adm-btn adm-btn-primary">Save FAQ</button>
        </div>
      </form>
      <?php else: ?>
      <div class="d-flex justify-content-between align-items-center mb-4"><h5 class="fw-bold">FAQs</h5><a href="faqs-manage.php?action=new" class="adm-btn adm-btn-primary">+ Add New</a></div>
      <div class="adm-card p-0">
        <table class="adm-table w-100">
          <thead><tr><th>#</th><th>Category</th><th>Question</th><th>Order</th><th>Actions</th></tr></thead>
          <tbody>
            <?php foreach ($faqs as $i => $row): ?>
            <tr><td><?= $i+1 ?></td><td><span class="adm-badge adm-badge-info"><?= $row['Category'] ?></span></td><td><?= htmlspecialchars($row['Question']) ?></td><td><?= $row['DisplayOrder'] ?></td>
            <td><a href="faqs-manage.php?action=edit&id=<?= $row['id'] ?>" class="adm-btn adm-btn-sm adm-btn-outline">Edit</a>
            <form method="POST" class="d-inline" onsubmit="return confirm('Delete?');"><input type="hidden" name="form_action" value="delete"><input type="hidden" name="delete_id" value="<?= $row['id'] ?>"><button type="submit" class="adm-btn adm-btn-sm adm-btn-danger">Delete</button></form></td></tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
