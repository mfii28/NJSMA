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
    
    // Handle Delete
    if ($formAction === 'delete') {
        $deleteId = (int)($_POST['delete_id'] ?? 0);
        if ($deleteId) {
            // Get image filename to delete file
            $item = $db->fetch("SELECT Image FROM tblassembly_members WHERE id=:id", ['id' => $deleteId]);
            if ($item && !empty($item['Image'])) {
                $imgPath = ROOT_PATH . '/dashboard/assets/img/members/' . $item['Image'];
                if (file_exists($imgPath)) unlink($imgPath);
            }
            $db->execute("DELETE FROM tblassembly_members WHERE id=:id", ['id' => $deleteId]);
            header('Location: members-manage.php?msg=Member deleted!'); exit;
        }
    }
    
    if ($formAction === 'save') {
        $name = trim($_POST['FullName'] ?? '');
        $area = $_POST['ElectoralArea'] ?? '';
        $pos  = $_POST['Position'] ?? 'Elected Member';
        $id   = (int)($_POST['id'] ?? 0);

        // Image upload
        $img = $_POST['existing_image'] ?? '';
        if (!empty($_FILES['Image']['name'])) {
            $ext = pathinfo($_FILES['Image']['name'], PATHINFO_EXTENSION);
            $img = 'mbr_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['Image']['tmp_name'], ROOT_PATH . '/dashboard/assets/img/members/' . $img);
        }

        if ($id) {
            $db->execute("UPDATE tblassembly_members SET FullName=:n, ElectoralArea=:a, Position=:p, Image=:i WHERE id=:id", ['n'=>$name,'a'=>$area,'p'=>$pos,'i'=>$img,'id'=>$id]);
        } else {
            $db->execute("INSERT INTO tblassembly_members (FullName, ElectoralArea, Position, Image) VALUES (:n,:a,:p,:i)", ['n'=>$name,'a'=>$area,'p'=>$pos,'i'=>$img]);
        }
        header('Location: members-manage.php?msg=Member saved!'); exit;
    }
}

if ($action === 'edit' && $editId) $item = $db->fetch("SELECT * FROM tblassembly_members WHERE id=:id", ['id'=>$editId]);
$members = $db->fetchAll("SELECT * FROM tblassembly_members ORDER BY FullName ASC");
$currentPage = 'Assembly Members';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><title>Manage Members – NJSMA Admin</title>
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
      <h5 class="fw-bold mb-4"><?= $item ? 'Edit Member' : 'New Assembly Member' ?></h5>
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="form_action" value="save"><input type="hidden" name="id" value="<?= $item['id'] ?? '' ?>"><input type="hidden" name="existing_image" value="<?= $item['Image'] ?? '' ?>">
        <div class="row g-3">
          <div class="col-lg-8"><div class="adm-card p-4">
            <div class="mb-3"><label class="adm-form-label">Full Name *</label><input type="text" name="FullName" class="adm-form-control" required value="<?= $item['FullName'] ?? '' ?>"></div>
            <div class="mb-3"><label class="adm-form-label">Electoral Area</label><input type="text" name="ElectoralArea" class="adm-form-control" value="<?= $item['ElectoralArea'] ?? '' ?>"></div>
            <div class="mb-0"><label class="adm-form-label">Position</label><select name="Position" class="adm-form-control"><option value="Elected Member" <?=($item['Position']??'')=='Elected Member'?'selected':''?>>Elected Member</option><option value="Appointee" <?=($item['Position']??'')=='Appointee'?'selected':''?>>Appointee</option></select></div>
          </div></div>
          <div class="col-lg-4 d-flex flex-column gap-3"><div class="adm-card p-4">
            <div class="mb-3"><label class="adm-form-label">Photo</label>
              <?php if(!empty($item['Image'])): ?><img src="assets/img/members/<?= $item['Image'] ?>" class="img-fluid rounded mb-2"><?php endif; ?>
              <input type="file" name="Image" class="adm-form-control">
            </div>
            <button type="submit" class="adm-btn adm-btn-primary w-100">Save Member</button>
          </div></div>
        </div>
      </form>
      <?php else: ?>
      <div class="d-flex justify-content-between align-items-center mb-4"><h5 class="fw-bold">Assembly Members</h5><a href="members-manage.php?action=new" class="adm-btn adm-btn-primary">+ Add New</a></div>
      <div class="adm-card p-0"><table class="adm-table w-100">
        <thead><tr><th>#</th><th>Image</th><th>Name</th><th>Electoral Area</th><th>Position</th><th>Actions</th></tr></thead>
        <tbody>
          <?php foreach ($members as $i => $row): ?>
          <tr><td><?= $i+1 ?></td><td><img src="assets/img/members/<?= $row['Image'] ?: 'default-user.jpg' ?>" class="rounded-circle" style="width:35px;height:35px;object-fit:cover;"></td><td class="fw-bold"><?= htmlspecialchars($row['FullName']) ?></td><td><?= $row['ElectoralArea'] ?></td><td><?= $row['Position'] ?></td>
          <td>
                <a href="members-manage.php?action=edit&id=<?= $row['id'] ?>" class="adm-btn adm-btn-sm adm-btn-outline">Edit</a>
                <form method="POST" class="d-inline" onsubmit="return confirm('Delete this member?');">
                  <input type="hidden" name="form_action" value="delete">
                  <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                  <button type="submit" class="adm-btn adm-btn-sm adm-btn-danger">Delete</button>
                </form>
              </td></tr>
          <?php endforeach; ?>
        </tbody>
      </table></div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
