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
            $item = $db->fetch("SELECT ThumbImage FROM tblgallery WHERE id=:id", ['id' => $deleteId]);
            if ($item && !empty($item['ThumbImage'])) {
                $imgPath = ROOT_PATH . '/dashboard/assets/img/gallery/' . $item['ThumbImage'];
                if (file_exists($imgPath)) unlink($imgPath);
            }
            $db->execute("DELETE FROM tblgallery WHERE id=:id", ['id' => $deleteId]);
            header('Location: gallery-manage.php?msg=Gallery item deleted!'); exit;
        }
    }
    
    if ($formAction === 'save') {
        $title = trim($_POST['Title'] ?? '');
        $desc  = $_POST['Description'] ?? '';
        $id    = (int)($_POST['id'] ?? 0);

        // Thumbnail upload
        $thumb = $_POST['existing_thumb'] ?? '';
        if (!empty($_FILES['ThumbImage']['name'])) {
            $ext = pathinfo($_FILES['ThumbImage']['name'], PATHINFO_EXTENSION);
            $thumb = 'gal_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['ThumbImage']['tmp_name'], ROOT_PATH . '/dashboard/assets/img/gallery/' . $thumb);
        }

        if ($id) {
            $db->execute("UPDATE tblgallery SET Title=:t, Description=:d, ThumbImage=:i WHERE id=:id", ['t'=>$title, 'd'=>$desc, 'i'=>$thumb, 'id'=>$id]);
        } else {
            $db->execute("INSERT INTO tblgallery (Title, Description, ThumbImage) VALUES (:t, :d, :i)", ['t'=>$title, 'd'=>$desc, 'i'=>$thumb]);
        }
        header('Location: gallery-manage.php?msg=Gallery item saved!'); exit;
    }
}

if ($action === 'edit' && $editId) $item = $db->fetch("SELECT * FROM tblgallery WHERE id=:id", ['id'=>$editId]);
$gallery = $db->fetchAll("SELECT * FROM tblgallery ORDER BY CreatedAt DESC");
$currentPage = 'Gallery';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><title>Manage Gallery – NJSMA Admin</title>
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
      <h5 class="fw-bold mb-4"><?= $item ? 'Edit Gallery' : 'New Gallery Item' ?></h5>
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="form_action" value="save"><input type="hidden" name="id" value="<?= $item['id'] ?? '' ?>"><input type="hidden" name="existing_thumb" value="<?= $item['ThumbImage'] ?? '' ?>">
        <div class="row g-3">
          <div class="col-lg-8"><div class="adm-card p-4">
            <div class="mb-3"><label class="adm-form-label">Title *</label><input type="text" name="Title" class="adm-form-control" required value="<?= $item['Title'] ?? '' ?>"></div>
            <div class="mb-0"><label class="adm-form-label">Description</label><textarea name="Description" rows="4" class="adm-form-control"><?= $item['Description'] ?? '' ?></textarea></div>
          </div></div>
          <div class="col-lg-4 d-flex flex-column gap-3"><div class="adm-card p-4">
            <div class="mb-3"><label class="adm-form-label">Cover Image</label>
              <?php if(!empty($item['ThumbImage'])): ?><img src="assets/img/gallery/<?= $item['ThumbImage'] ?>" class="img-fluid rounded mb-2"><?php endif; ?>
              <input type="file" name="ThumbImage" class="adm-form-control">
            </div>
            <button type="submit" class="adm-btn adm-btn-primary w-100">Save Item</button>
          </div></div>
        </div>
      </form>
      <?php else: ?>
      <div class="d-flex justify-content-between align-items-center mb-4"><h5 class="fw-bold">Media Gallery</h5><a href="gallery-manage.php?action=new" class="adm-btn adm-btn-primary">+ Add New</a></div>
      <div class="row g-3">
        <?php foreach ($gallery as $row): ?>
        <div class="col-md-4 col-lg-3">
          <div class="adm-card h-100">
            <img src="assets/img/gallery/<?= $row['ThumbImage'] ?: 'placeholder.jpg' ?>" class="card-img-top" style="height:160px;object-fit:cover;">
            <div class="p-3">
              <h6 class="fw-bold mb-1"><?= htmlspecialchars($row['Title']) ?></h6>
              <div class="d-flex gap-2 mt-3">
                <a href="gallery-manage.php?action=edit&id=<?= $row['id'] ?>" class="adm-btn adm-btn-sm adm-btn-outline flex-grow-1 text-center justify-content-center">Edit</a>
                <form method="POST" class="flex-grow-1" onsubmit="return confirm('Delete?');"><input type="hidden" name="form_action" value="delete"><input type="hidden" name="delete_id" value="<?= $row['id'] ?>"><button type="submit" class="adm-btn adm-btn-sm adm-btn-danger w-100 justify-content-center">Delete</button></form>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
