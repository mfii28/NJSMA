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
        $title = trim($_POST['PageTitle'] ?? '');
        $slug  = trim($_POST['PageSlug'] ?? '');
        $content = $_POST['PageContent'] ?? '';
        $meta = $_POST['MetaDescription'] ?? '';
        $active = isset($_POST['IsActive']) ? 1 : 0;
        $id = (int)($_POST['id'] ?? 0);

        if ($id) {
            $db->execute("UPDATE tblpages SET PageTitle=:t, PageSlug=:s, PageContent=:c, MetaDescription=:m, IsActive=:a WHERE id=:id",
                ['t'=>$title, 's'=>$slug, 'c'=>$content, 'm'=>$meta, 'a'=>$active, 'id'=>$id]);
            $msg = 'Page updated!';
        } else {
            $db->execute("INSERT INTO tblpages (PageTitle, PageSlug, PageContent, MetaDescription, IsActive) VALUES (:t,:s,:c,:m,:a)",
                ['t'=>$title, 's'=>$slug, 'c'=>$content, 'm'=>$meta, 'a'=>$active]);
            $msg = 'Page created!';
        }
        header('Location: pages-manage.php?msg=' . urlencode($msg)); exit;
    }

    if ($formAction === 'delete') {
        $db->execute("DELETE FROM tblpages WHERE id=:id", ['id' => (int)$_POST['delete_id']]);
        header('Location: pages-manage.php?msg=' . urlencode('Page deleted.')); exit;
    }
}

if ($action === 'edit' && $editId) {
    $item = $db->fetch("SELECT * FROM tblpages WHERE id=:id", ['id' => $editId]);
}

if (isset($_GET['msg'])) $msg = $_GET['msg'];
$pages = $db->fetchAll("SELECT * FROM tblpages ORDER BY PageTitle ASC");
$currentPage = 'Static Pages';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><title>Manage Static Pages – NJSMA Admin</title>
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
        <div><h5 class="fw-bold"><?= $item ? 'Edit Static Page' : 'New Static Page' ?></h5></div>
        <a href="pages-manage.php" class="adm-btn adm-btn-outline">Back</a>
      </div>
      <form method="POST">
        <input type="hidden" name="form_action" value="save">
        <input type="hidden" name="id" value="<?= $item['id'] ?? '' ?>">
        <div class="row g-3">
          <div class="col-lg-8">
            <div class="adm-card p-4">
              <div class="mb-3"><label class="adm-form-label">Page Title *</label><input type="text" name="PageTitle" class="adm-form-control" required value="<?= $item['PageTitle'] ?? '' ?>"></div>
              <div class="mb-3"><label class="adm-form-label">Page Content (HTML support)</label><textarea name="PageContent" rows="20" class="adm-form-control"><?= $item['PageContent'] ?? '' ?></textarea></div>
            </div>
          </div>
          <div class="col-lg-4 d-flex flex-column gap-3">
            <div class="adm-card p-4">
              <div class="mb-3"><label class="adm-form-label">Page Slug (URL identifier) *</label><input type="text" name="PageSlug" class="adm-form-control" required value="<?= $item['PageSlug'] ?? '' ?>" placeholder="privacy-policy"></div>
              <div class="mb-3"><label class="adm-form-label">Meta Description (SEO)</label><textarea name="MetaDescription" rows="3" class="adm-form-control"><?= $item['MetaDescription'] ?? '' ?></textarea></div>
              <div class="mb-3">
                <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="IsActive" id="pActive" <?= (!isset($item) || $item['IsActive']) ? 'checked' : '' ?>><label class="form-check-label" for="pActive">Page is Active</label></div>
              </div>
              <button type="submit" class="adm-btn adm-btn-primary w-100">Save Page</button>
            </div>
            <div class="adm-card p-4 small text-muted">
              <i class="bi bi-info-circle me-1"></i> These pages are used for legal requirements like Privacy Policies, Terms of Service, and Accessibility Statements.
            </div>
          </div>
        </div>
      </form>
      <?php else: ?>
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="fw-bold">Static Pages</h5></div>
        <a href="pages-manage.php?action=new" class="adm-btn adm-btn-primary">+ Create Page</a>
      </div>
      <div class="adm-card p-0">
        <table class="adm-table w-100">
          <thead><tr><th>#</th><th>Title</th><th>Slug / URL</th><th>Last Updated</th><th>Status</th><th>Actions</th></tr></thead>
          <tbody>
            <?php foreach ($pages as $i => $row): ?>
            <tr>
              <td><?= $i+1 ?></td>
              <td class="fw-bold"><?= htmlspecialchars($row['PageTitle']) ?></td>
              <td><code>/page/<?= $row['PageSlug'] ?></code></td>
              <td><?= date('M d, Y', strtotime($row['UpdatedAt'])) ?></td>
              <td><span class="adm-badge <?= $row['IsActive'] ? 'adm-badge-success' : 'adm-badge-warning' ?>"><?= $row['IsActive'] ? 'Active' : 'Draft' ?></span></td>
              <td>
                <a href="pages-manage.php?action=edit&id=<?= $row['id'] ?>" class="adm-btn adm-btn-sm adm-btn-outline">Edit</a>
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
