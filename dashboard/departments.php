<?php
require_once __DIR__ . '/../src/init.php';
if (empty($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }

$db = \Core\Database::getInstance();
$msg = $_GET['msg'] ?? '';
$action = $_GET['action'] ?? 'list';
$editId = (int)($_GET['id'] ?? 0);
$item = null;

// Create departments image folder if not exists
$deptImgPath = ROOT_PATH . '/dashboard/assets/img/departments/';
if (!is_dir($deptImgPath)) {
    mkdir($deptImgPath, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formAction = $_POST['form_action'] ?? '';
    
    // Handle Delete
    if ($formAction === 'delete') {
        $deleteId = (int)($_POST['delete_id'] ?? 0);
        if ($deleteId) {
            // Get image filename to delete file
            $item = $db->fetch("SELECT HeadImage FROM tbldepartments WHERE id=:id", ['id' => $deleteId]);
            if ($item && !empty($item['HeadImage'])) {
                $imgPath = $deptImgPath . $item['HeadImage'];
                if (file_exists($imgPath)) unlink($imgPath);
            }
            $db->execute("DELETE FROM tbldepartments WHERE id=:id", ['id' => $deleteId]);
            header('Location: departments.php?msg=Department deleted!'); exit;
        }
    }
    
    if ($formAction === 'save') {
        $deptName = trim($_POST['DeptName'] ?? '');
        $description = $_POST['Description'] ?? '';
        $objectives = $_POST['Objectives'] ?? '';
        $functions = $_POST['Functions'] ?? '';
        $headName = trim($_POST['HeadName'] ?? '');
        $headTitle = trim($_POST['HeadTitle'] ?? '');
        $adminDetails = $_POST['AdminDetails'] ?? '';
        $id = (int)($_POST['id'] ?? 0);

        // Image upload for department head
        $headImage = $_POST['existing_head_image'] ?? '';
        if (!empty($_FILES['HeadImage']['name'])) {
            $ext = strtolower(pathinfo($_FILES['HeadImage']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($ext, $allowed)) {
                $headImage = 'dept_' . time() . '.' . $ext;
                move_uploaded_file($_FILES['HeadImage']['tmp_name'], $deptImgPath . $headImage);
            }
        }

        if ($id) {
            $db->execute("UPDATE tbldepartments SET DeptName=:n, Description=:d, Objectives=:o, Functions=:f, HeadName=:hn, HeadTitle=:ht, HeadImage=:hi, AdminDetails=:ad WHERE id=:id",
                ['n'=>$deptName, 'd'=>$description, 'o'=>$objectives, 'f'=>$functions, 'hn'=>$headName, 'ht'=>$headTitle, 'hi'=>$headImage, 'ad'=>$adminDetails, 'id'=>$id]);
            $msg = 'Department updated!';
        } else {
            $db->execute("INSERT INTO tbldepartments (DeptName, Description, Objectives, Functions, HeadName, HeadTitle, HeadImage, AdminDetails) VALUES (:n,:d,:o,:f,:hn,:ht,:hi,:ad)",
                ['n'=>$deptName, 'd'=>$description, 'o'=>$objectives, 'f'=>$functions, 'hn'=>$headName, 'ht'=>$headTitle, 'hi'=>$headImage, 'ad'=>$adminDetails]);
            $msg = 'Department added!';
        }
        header('Location: departments.php?msg=' . urlencode($msg)); exit;
    }
}

if ($action === 'edit' && $editId) {
    $item = $db->fetch("SELECT * FROM tbldepartments WHERE id=:id", ['id' => $editId]);
}

$departments = $db->fetchAll("SELECT * FROM tbldepartments ORDER BY DeptName ASC");
$currentPage = 'Departments';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><title>Manage Departments – NJSMA Admin</title>
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
        <h5 class="fw-bold"><?= $item ? 'Edit Department' : 'New Department' ?></h5>
        <a href="departments.php" class="adm-btn adm-btn-outline">Back</a>
      </div>
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="form_action" value="save">
        <input type="hidden" name="id" value="<?= $item['id'] ?? '' ?>">
        <input type="hidden" name="existing_head_image" value="<?= $item['HeadImage'] ?? '' ?>">
        
        <div class="row g-3">
          <div class="col-lg-8">
            <div class="adm-card p-4 mb-3">
              <h6 class="fw-bold mb-3 text-primary">Department Information</h6>
              <div class="mb-3">
                <label class="adm-form-label">Department Name *</label>
                <input type="text" name="DeptName" class="adm-form-control" required value="<?= htmlspecialchars($item['DeptName'] ?? '') ?>">
              </div>
              <div class="mb-3">
                <label class="adm-form-label">Description</label>
                <textarea name="Description" rows="4" class="adm-form-control" placeholder="Department description and mandate..."><?= htmlspecialchars($item['Description'] ?? '') ?></textarea>
              </div>
              <div class="mb-3">
                <label class="adm-form-label">Objectives</label>
                <textarea name="Objectives" rows="3" class="adm-form-control" placeholder="Key objectives..."><?= htmlspecialchars($item['Objectives'] ?? '') ?></textarea>
              </div>
              <div class="mb-0">
                <label class="adm-form-label">Functions & Roles</label>
                <textarea name="Functions" rows="4" class="adm-form-control" placeholder="Department functions and responsibilities..."><?= htmlspecialchars($item['Functions'] ?? '') ?></textarea>
              </div>
            </div>
            
            <div class="adm-card p-4">
              <h6 class="fw-bold mb-3 text-primary">Administrative Details</h6>
              <div class="mb-0">
                <label class="adm-form-label">Additional Admin Info</label>
                <textarea name="AdminDetails" rows="3" class="adm-form-control" placeholder="Location, contact info, working hours..."><?= htmlspecialchars($item['AdminDetails'] ?? '') ?></textarea>
              </div>
            </div>
          </div>
          
          <div class="col-lg-4">
            <div class="adm-card p-4">
              <h6 class="fw-bold mb-3 text-primary">Department Head</h6>
              <div class="mb-3">
                <label class="adm-form-label">Head Name</label>
                <input type="text" name="HeadName" class="adm-form-control" value="<?= htmlspecialchars($item['HeadName'] ?? '') ?>" placeholder="e.g. Dr. John Doe">
              </div>
              <div class="mb-3">
                <label class="adm-form-label">Head Title</label>
                <input type="text" name="HeadTitle" class="adm-form-control" value="<?= htmlspecialchars($item['HeadTitle'] ?? '') ?>" placeholder="e.g. Director, Head of Department">
              </div>
              <div class="mb-3">
                <label class="adm-form-label">Head Photo</label>
                <?php if(!empty($item['HeadImage'])): ?>
                  <img src="assets/img/departments/<?= $item['HeadImage'] ?>" class="img-fluid rounded mb-2" style="max-height:150px;object-fit:cover;">
                <?php endif; ?>
                <input type="file" name="HeadImage" class="adm-form-control" accept="image/*">
                <small class="text-muted">Upload department head photo (JPG, PNG, GIF)</small>
              </div>
              <button type="submit" class="adm-btn adm-btn-primary w-100">Save Department</button>
            </div>
          </div>
        </div>
      </form>
      
      <?php else: ?>
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold">Departments</h5>
        <a href="departments.php?action=new" class="adm-btn adm-btn-primary">+ Add Department</a>
      </div>
      
      <div class="row g-3">
        <?php foreach ($departments as $dept): ?>
        <div class="col-md-6 col-lg-4">
          <div class="adm-card h-100">
            <div class="p-3">
              <div class="d-flex align-items-start gap-3 mb-3">
                <img src="assets/img/departments/<?= $dept['HeadImage'] ?: 'default-user.jpg' ?>" class="rounded-circle" style="width:60px;height:60px;object-fit:cover;">
                <div>
                  <h6 class="fw-bold mb-1"><?= htmlspecialchars($dept['DeptName']) ?></h6>
                  <p class="text-muted small mb-0"><?= htmlspecialchars($dept['HeadName'] ?: 'No head assigned') ?></p>
                  <small class="text-primary"><?= htmlspecialchars($dept['HeadTitle'] ?: '') ?></small>
                </div>
              </div>
              <p class="text-muted small mb-3" style="height:60px;overflow:hidden;"><?= htmlspecialchars(substr($dept['Description'] ?? '', 0, 100)) ?><?= strlen($dept['Description'] ?? '') > 100 ? '...' : '' ?></p>
              <div class="d-flex gap-2">
                <a href="departments.php?action=edit&id=<?= $dept['id'] ?>" class="adm-btn adm-btn-sm adm-btn-outline flex-grow-1 text-center">Edit</a>
                <form method="POST" class="flex-grow-1" onsubmit="return confirm('Delete this department?');">
                  <input type="hidden" name="form_action" value="delete">
                  <input type="hidden" name="delete_id" value="<?= $dept['id'] ?>">
                  <button type="submit" class="adm-btn adm-btn-sm adm-btn-danger w-100">Delete</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
        
        <?php if (empty($departments)): ?>
        <div class="col-12">
          <div class="adm-card p-5 text-center">
            <i class="bi bi-building fs-1 text-muted mb-3"></i>
            <h6>No Departments Found</h6>
            <p class="text-muted small">Add departments to organize your municipal structure.</p>
            <a href="departments.php?action=new" class="adm-btn adm-btn-primary mt-2">Add First Department</a>
          </div>
        </div>
        <?php endif; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
