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
        $name = trim($_POST['FullName'] ?? '');
        $pos  = $_POST['Position'] ?? '';
        $bio  = $_POST['Bio'] ?? '';
        $rank = (int)($_POST['Rank'] ?? 0);
        $id   = (int)($_POST['id'] ?? 0);

        // Image upload
        $img = $_POST['existing_image'] ?? '';
        if (!empty($_FILES['Image']['name'])) {
            $ext = pathinfo($_FILES['Image']['name'], PATHINFO_EXTENSION);
            $img = 'mgmt_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['Image']['tmp_name'], ROOT_PATH . '/dashboard/assets/img/management/' . $img);
        }

        if ($id) {
            $db->execute("UPDATE tblmanagement SET FullName=:n, Position=:p, Bio=:b, Rank=:r, Image=:i WHERE id=:id",
                ['n'=>$name, 'p'=>$pos, 'b'=>$bio, 'r'=>$rank, 'i'=>$img, 'id'=>$id]);
            $msg = 'Management member updated!';
        } else {
            $db->execute("INSERT INTO tblmanagement (FullName, Position, Bio, Rank, Image) VALUES (:n,:p,:b,:r,:i)",
                ['n'=>$name, 'p'=>$pos, 'b'=>$bio, 'r'=>$rank, 'i'=>$img]);
            $msg = 'Management member added!';
        }
        header('Location: management-manage.php?msg=' . urlencode($msg)); exit;
    }

    if ($formAction === 'delete') {
        $db->execute("DELETE FROM tblmanagement WHERE id=:id", ['id' => (int)$_POST['delete_id']]);
        header('Location: management-manage.php?msg=' . urlencode('Member deleted.')); exit;
    }
}

if ($action === 'edit' && $editId) {
    $item = $db->fetch("SELECT * FROM tblmanagement WHERE id=:id", ['id' => $editId]);
}

$team = $db->fetchAll("SELECT * FROM tblmanagement ORDER BY Rank ASC, FullName ASC");
$currentPage = 'Management Team';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><title>Manage Team – NJSMA Admin</title>
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
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold"><?= $item ? 'Edit Member' : 'New Management Member' ?></h5>
        <a href="management-manage.php" class="adm-btn adm-btn-outline">Back</a>
      </div>
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="form_action" value="save"><input type="hidden" name="id" value="<?= $item['id'] ?? '' ?>"><input type="hidden" name="existing_image" value="<?= $item['Image'] ?? '' ?>">
        <div class="row g-3">
          <div class="col-lg-8">
            <div class="adm-card p-4">
              <div class="mb-3"><label class="adm-form-label">Full Name *</label><input type="text" name="FullName" class="adm-form-control" required value="<?= $item['FullName'] ?? '' ?>"></div>
              <div class="mb-3"><label class="adm-form-label">Position / Designation *</label><input type="text" name="Position" class="adm-form-control" required value="<?= $item['Position'] ?? '' ?>"></div>
              <div class="mb-0"><label class="adm-form-label">Bio (Optional)</label><textarea name="Bio" rows="6" class="adm-form-control"><?= $item['Bio'] ?? '' ?></textarea></div>
            </div>
          </div>
          <div class="col-lg-4 d-flex flex-column gap-3">
            <div class="adm-card p-4">
              <div class="mb-3"><label class="adm-form-label">Display Rank (Order)</label><input type="number" name="Rank" class="adm-form-control" value="<?= $item['Rank'] ?? 0 ?>"><small class="text-muted">Lower numbers appear first.</small></div>
              <div class="mb-3"><label class="adm-form-label">Profile Image</label>
                <?php if(!empty($item['Image'])): ?><img src="assets/img/management/<?= $item['Image'] ?>" class="img-fluid rounded mb-2"><?php endif; ?>
                <input type="file" name="Image" class="adm-form-control">
              </div>
              <button type="submit" class="adm-btn adm-btn-primary w-100">Save Member</button>
            </div>
          </div>
        </div>
      </form>
      <?php else: ?>
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold">Management Team</h5>
        <a href="management-manage.php?action=new" class="adm-btn adm-btn-primary">+ Add Member</a>
      </div>
      <div class="adm-card p-0">
        <table class="adm-table w-100">
          <thead><tr><th>#</th><th>Image</th><th>Name</th><th>Position</th><th>Rank</th><th>Actions</th></tr></thead>
          <tbody>
            <?php foreach ($team as $i => $row): ?>
            <tr>
              <td><?= $i+1 ?></td>
              <td><img src="assets/img/management/<?= $row['Image'] ?: 'default-user.jpg' ?>" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;"></td>
              <td class="fw-bold"><?= htmlspecialchars($row['FullName']) ?></td>
              <td class="text-muted"><?= htmlspecialchars($row['Position']) ?></td>
              <td><?= $row['Rank'] ?></td>
              <td>
                <a href="management-manage.php?action=edit&id=<?= $row['id'] ?>" class="adm-btn adm-btn-sm adm-btn-outline">Edit</a>
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
</body>
</html>
