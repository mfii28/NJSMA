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
        $name = trim($_POST['CouncilName'] ?? '');
        $chair = $_POST['Chairman'] ?? '';
        $desc = $_POST['Description'] ?? '';
        $loc = $_POST['Location'] ?? '';
        $phone = $_POST['ContactPhone'] ?? '';
        $id = (int)($_POST['id'] ?? 0);

        if ($id) {
            $db->execute("UPDATE tblzonal_councils SET CouncilName=:n, Chairman=:c, Description=:d, Location=:l, ContactPhone=:p WHERE id=:id", ['n'=>$name, 'c'=>$chair, 'd'=>$desc, 'l'=>$loc, 'p'=>$phone, 'id'=>$id]);
        } else {
            $db->execute("INSERT INTO tblzonal_councils (CouncilName, Chairman, Description, Location, ContactPhone) VALUES (:n, :c, :d, :l, :p)", ['n'=>$name, 'c'=>$chair, 'd'=>$desc, 'l'=>$loc, 'p'=>$phone]);
        }
        header('Location: zonal-councils.php?msg=Zonal Council saved!'); exit;
    }
}

if ($action === 'edit' && $editId) $item = $db->fetch("SELECT * FROM tblzonal_councils WHERE id=:id", ['id'=>$editId]);
$councils = $db->fetchAll("SELECT * FROM tblzonal_councils ORDER BY CouncilName ASC");
$currentPage = 'Zonal Councils';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><title>Manage Zonal Councils – NJSMA Admin</title>
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
      <h5 class="fw-bold mb-4"><?= $item ? 'Edit Zonal Council' : 'New Zonal Council' ?></h5>
      <form method="POST">
        <input type="hidden" name="form_action" value="save"><input type="hidden" name="id" value="<?= $item['id'] ?? '' ?>">
        <div class="adm-card p-4">
          <div class="row g-3">
            <div class="col-md-6"><label class="adm-form-label">Council Name *</label><input type="text" name="CouncilName" class="adm-form-control" required value="<?= $item['CouncilName'] ?? '' ?>"></div>
            <div class="col-md-6"><label class="adm-form-label">Chairman / Zonal Lead</label><input type="text" name="Chairman" class="adm-form-control" value="<?= $item['Chairman'] ?? '' ?>"></div>
            <div class="col-12"><label class="adm-form-label">Description</label><textarea name="Description" rows="4" class="adm-form-control"><?= $item['Description'] ?? '' ?></textarea></div>
            <div class="col-md-6"><label class="adm-form-label">Location / Area</label><input type="text" name="Location" class="adm-form-control" value="<?= $item['Location'] ?? '' ?>"></div>
            <div class="col-md-6"><label class="adm-form-label">Contact Phone</label><input type="text" name="ContactPhone" class="adm-form-control" value="<?= $item['ContactPhone'] ?? '' ?>"></div>
          </div>
          <button type="submit" class="adm-btn adm-btn-primary mt-4">Save Council</button>
        </div>
      </form>
      <?php else: ?>
      <div class="d-flex justify-content-between align-items-center mb-4"><h5 class="fw-bold">Zonal Councils</h5><a href="zonal-councils.php?action=new" class="adm-btn adm-btn-primary">+ Add New</a></div>
      <div class="adm-card p-0"><table class="adm-table w-100">
        <thead><tr><th>#</th><th>Council Name</th><th>Chairman</th><th>Location</th><th>Phone</th><th>Actions</th></tr></thead>
        <tbody>
          <?php foreach ($councils as $i => $row): ?>
          <tr><td><?= $i+1 ?></td><td class="fw-bold"><?= htmlspecialchars($row['CouncilName']) ?></td><td><?= $row['Chairman'] ?></td><td><?= $row['Location'] ?></td><td><?= $row['ContactPhone'] ?></td>
          <td><a href="zonal-councils.php?action=edit&id=<?= $row['id'] ?>" class="adm-btn adm-btn-sm adm-btn-outline">Edit</a></td></tr>
          <?php endforeach; ?>
        </tbody>
      </table></div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
