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
        $title = trim($_POST['Title'] ?? '');
        $cat   = $_POST['Category'] ?? 'General';
        $desc  = $_POST['Description'] ?? '';
        $id    = (int)($_POST['id'] ?? 0);

        // File upload
        $file = $_POST['existing_file'] ?? '';
        if (!empty($_FILES['DocFile']['name'])) {
            $ext = pathinfo($_FILES['DocFile']['name'], PATHINFO_EXTENSION);
            $file = 'doc_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['DocFile']['tmp_name'], ROOT_PATH . '/docs/' . $file);
        }

        if ($id) {
            $db->execute("UPDATE tbldocuments SET Title=:t, Category=:c, Description=:d, FilePath=:f WHERE id=:id", ['t'=>$title, 'c'=>$cat, 'd'=>$desc, 'f'=>$file, 'id'=>$id]);
        } else {
            $db->execute("INSERT INTO tbldocuments (Title, Category, Description, FilePath) VALUES (:t, :c, :d, :f)", ['t'=>$title, 'c'=>$cat, 'd'=>$desc, 'f'=>$file]);
        }
        header('Location: repository-manage.php?msg=Document saved!'); exit;
    }
}

if ($action === 'edit' && $editId) $item = $db->fetch("SELECT * FROM tbldocuments WHERE id=:id", ['id'=>$editId]);
$docs = $db->fetchAll("SELECT * FROM tbldocuments ORDER BY UploadDate DESC");
$currentPage = 'Documents Center';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><title>Manage Documents – NJSMA Admin</title>
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
      <h5 class="fw-bold mb-4"><?= $item ? 'Edit Document' : 'New Document' ?></h5>
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="form_action" value="save"><input type="hidden" name="id" value="<?= $item['id'] ?? '' ?>"><input type="hidden" name="existing_file" value="<?= $item['FilePath'] ?? '' ?>">
        <div class="row g-3">
          <div class="col-lg-8"><div class="adm-card p-4">
            <div class="mb-3"><label class="adm-form-label">Title *</label><input type="text" name="Title" class="adm-form-control" required value="<?= $item['Title'] ?? '' ?>"></div>
            <div class="mb-0"><label class="adm-form-label">Description</label><textarea name="Description" rows="4" class="adm-form-control"><?= $item['Description'] ?? '' ?></textarea></div>
          </div></div>
          <div class="col-lg-4 d-flex flex-column gap-3"><div class="adm-card p-4">
            <div class="mb-3"><label class="adm-form-label">Category</label><input type="text" name="Category" class="adm-form-control" value="<?= $item['Category'] ?? 'General' ?>"></div>
            <div class="mb-3"><label class="adm-form-label">File (PDF, Word, etc.)</label><input type="file" name="DocFile" class="adm-form-control"></div>
            <button type="submit" class="adm-btn adm-btn-primary w-100">Save Document</button>
          </div></div>
        </div>
      </form>
      <?php else: ?>
      <div class="d-flex justify-content-between align-items-center mb-4"><h5 class="fw-bold">Documents Center</h5><a href="repository-manage.php?action=new" class="adm-btn adm-btn-primary">+ Add New</a></div>
      <div class="adm-card p-0"><table class="adm-table w-100">
        <thead><tr><th>#</th><th>Title</th><th>Category</th><th>Upload Date</th><th>Actions</th></tr></thead>
        <tbody>
          <?php foreach ($docs as $i => $row): ?>
          <tr><td><?= $i+1 ?></td><td class="fw-bold"><?= htmlspecialchars($row['Title']) ?></td><td><span class="adm-badge adm-badge-info"><?= $row['Category'] ?></span></td><td><?= date('M d, Y', strtotime($row['UploadDate'])) ?></td>
          <td><a href="repository-manage.php?action=edit&id=<?= $row['id'] ?>" class="adm-btn adm-btn-sm adm-btn-outline">Edit</a></td></tr>
          <?php endforeach; ?>
        </tbody>
      </table></div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
