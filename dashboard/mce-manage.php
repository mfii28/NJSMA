<?php
require_once __DIR__ . '/../src/init.php';
if (empty($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }

use Models\MceModel;

$mceModel = new MceModel();
$msg = '';
$action = $_GET['action'] ?? 'list';
$editId = (int)($_GET['id'] ?? 0);
$item = null;

// Ensure profile image directory exists
$mceImgPath = ROOT_PATH . '/dashboard/assets/img/profileImg/';
if (!is_dir($mceImgPath)) {
    mkdir($mceImgPath, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formAction = $_POST['form_action'] ?? '';
    
    // Handle Delete
    if ($formAction === 'delete') {
        $deleteId = (int)($_POST['delete_id'] ?? 0);
        if ($deleteId) {
            // Get image filename to delete file
            $mceToDelete = $mceModel->getById($deleteId);
            if ($mceToDelete && !empty($mceToDelete['image'])) {
                $imgPath = $mceImgPath . $mceToDelete['image'];
                if (file_exists($imgPath)) unlink($imgPath);
            }
            $mceModel->delete($deleteId);
            header('Location: mce-manage.php?msg=MCE record deleted!'); exit;
        }
    }
    
    // Handle Set Active
    if ($formAction === 'activate') {
        $activateId = (int)($_POST['activate_id'] ?? 0);
        if ($activateId) {
            $mceModel->setActive($activateId);
            header('Location: mce-manage.php?msg=MCE set as current!'); exit;
        }
    }
    
    if ($formAction === 'save') {
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $title = trim($_POST['title'] ?? 'Municipal Chief Executive');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $biography = $_POST['biography'] ?? '';
        $vision = $_POST['vision'] ?? '';
        $education = $_POST['education'] ?? '';
        $termStart = $_POST['term_start'] ?? date('Y-m-d');
        $termEnd = $_POST['term_end'] ?? '';
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        $socialFacebook = trim($_POST['social_facebook'] ?? '');
        $socialTwitter = trim($_POST['social_twitter'] ?? '');
        $socialLinkedin = trim($_POST['social_linkedin'] ?? '');
        $contactEmail = trim($_POST['contact_email'] ?? '');
        $id = (int)($_POST['id'] ?? 0);

        // Image upload
        $image = $_POST['existing_image'] ?? '';
        if (!empty($_FILES['mce_image']['name'])) {
            $ext = strtolower(pathinfo($_FILES['mce_image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($ext, $allowed)) {
                $image = 'mce_' . time() . '.' . $ext;
                move_uploaded_file($_FILES['mce_image']['tmp_name'], $mceImgPath . $image);
            }
        }

        $data = [
            'id' => $id,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'title' => $title,
            'email' => $email,
            'phone' => $phone,
            'biography' => $biography,
            'vision' => $vision,
            'education' => $education,
            'term_start' => $termStart,
            'term_end' => $termEnd,
            'is_active' => $isActive,
            'social_facebook' => $socialFacebook,
            'social_twitter' => $socialTwitter,
            'social_linkedin' => $socialLinkedin,
            'contact_email' => $contactEmail,
            'image' => $image
        ];

        $mceModel->save($data);
        
        // If this is set as active, deactivate others
        if ($isActive && !$id) {
            $newId = $db->lastInsertId();
            $mceModel->setActive($newId);
        } elseif ($isActive && $id) {
            $mceModel->setActive($id);
        }
        
        $msg = $id ? 'MCE updated!' : 'New MCE added!';
        header('Location: mce-manage.php?msg=' . urlencode($msg)); exit;
    }
}

if ($action === 'edit' && $editId) {
    $item = $mceModel->getById($editId);
}

$mces = $mceModel->getAllMces();
$currentPage = 'MCE Management';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><title>Manage MCE – NJSMA Admin</title>
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
        <div><h5 class="fw-bold"><?= $item ? 'Edit MCE' : 'New MCE' ?></h5></div>
        <a href="mce-manage.php" class="adm-btn adm-btn-outline">Back</a>
      </div>
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="form_action" value="save">
        <input type="hidden" name="id" value="<?= $item['id'] ?? '' ?>">
        <input type="hidden" name="existing_image" value="<?= $item['image'] ?? '' ?>">
        
        <div class="row g-3">
          <div class="col-lg-8">
            <div class="adm-card p-4 mb-3">
              <h6 class="fw-bold mb-3 text-primary">Personal Information</h6>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="adm-form-label">First Name *</label>
                  <input type="text" name="first_name" class="adm-form-control" required value="<?= htmlspecialchars($item['first_name'] ?? '') ?>">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="adm-form-label">Last Name *</label>
                  <input type="text" name="last_name" class="adm-form-control" required value="<?= htmlspecialchars($item['last_name'] ?? '') ?>">
                </div>
              </div>
              <div class="mb-3">
                <label class="adm-form-label">Title</label>
                <input type="text" name="title" class="adm-form-control" value="<?= htmlspecialchars($item['title'] ?? 'Municipal Chief Executive') ?>">
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="adm-form-label">Email</label>
                  <input type="email" name="email" class="adm-form-control" value="<?= htmlspecialchars($item['email'] ?? '') ?>">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="adm-form-label">Phone</label>
                  <input type="text" name="phone" class="adm-form-control" value="<?= htmlspecialchars($item['phone'] ?? '') ?>">
                </div>
              </div>
              <div class="mb-3">
                <label class="adm-form-label">Contact Email (Public)</label>
                <input type="email" name="contact_email" class="adm-form-control" value="<?= htmlspecialchars($item['contact_email'] ?? '') ?>">
                <small class="text-muted">Email displayed on public MCE page</small>
              </div>
            </div>
            
            <div class="adm-card p-4 mb-3">
              <h6 class="fw-bold mb-3 text-primary">Biography & Vision</h6>
              <div class="mb-3">
                <label class="adm-form-label">Biography</label>
                <textarea name="biography" rows="5" class="adm-form-control"><?= htmlspecialchars($item['biography'] ?? '') ?></textarea>
              </div>
              <div class="mb-3">
                <label class="adm-form-label">Vision Statement</label>
                <textarea name="vision" rows="3" class="adm-form-control"><?= htmlspecialchars($item['vision'] ?? '') ?></textarea>
              </div>
              <div class="mb-0">
                <label class="adm-form-label">Education & Background</label>
                <textarea name="education" rows="4" class="adm-form-control"><?= htmlspecialchars($item['education'] ?? '') ?></textarea>
              </div>
            </div>
          </div>
          
          <div class="col-lg-4">
            <div class="adm-card p-4 mb-3">
              <h6 class="fw-bold mb-3 text-primary">Photo</h6>
              <?php if(!empty($item['image'])): ?>
                <img src="assets/img/profileImg/<?= $item['image'] ?>" class="img-fluid rounded mb-2" style="max-height:200px;object-fit:cover;">
              <?php else: ?>
                <img src="assets/img/profileImg/mce.jpg" class="img-fluid rounded mb-2" style="max-height:200px;object-fit:cover;">
              <?php endif; ?>
              <input type="file" name="mce_image" class="adm-form-control" accept="image/*">
              <small class="text-muted">Upload MCE official photo</small>
            </div>
            
            <div class="adm-card p-4 mb-3">
              <h6 class="fw-bold mb-3 text-primary">Term Period</h6>
              <div class="mb-3">
                <label class="adm-form-label">Term Start</label>
                <input type="date" name="term_start" class="adm-form-control" value="<?= $item['term_start'] ?? date('Y-m-d') ?>">
              </div>
              <div class="mb-3">
                <label class="adm-form-label">Term End (Optional)</label>
                <input type="date" name="term_end" class="adm-form-control" value="<?= $item['term_end'] ?? '' ?>">
              </div>
              <div class="form-check mb-0">
                <input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1" <?= ($item['is_active'] ?? 0) ? 'checked' : '' ?>>
                <label class="form-check-label" for="isActive">Current Active MCE</label>
              </div>
            </div>
            
            <div class="adm-card p-4 mb-3">
              <h6 class="fw-bold mb-3 text-primary">Social Media</h6>
              <div class="mb-3">
                <label class="adm-form-label"><i class="bi bi-facebook"></i> Facebook</label>
                <input type="url" name="social_facebook" class="adm-form-control" value="<?= htmlspecialchars($item['social_facebook'] ?? '') ?>" placeholder="https://facebook.com/...">
              </div>
              <div class="mb-3">
                <label class="adm-form-label"><i class="bi bi-twitter-x"></i> Twitter/X</label>
                <input type="url" name="social_twitter" class="adm-form-control" value="<?= htmlspecialchars($item['social_twitter'] ?? '') ?>" placeholder="https://twitter.com/...">
              </div>
              <div class="mb-0">
                <label class="adm-form-label"><i class="bi bi-linkedin"></i> LinkedIn</label>
                <input type="url" name="social_linkedin" class="adm-form-control" value="<?= htmlspecialchars($item['social_linkedin'] ?? '') ?>" placeholder="https://linkedin.com/...">
              </div>
            </div>
            
            <button type="submit" class="adm-btn adm-btn-primary w-100">Save MCE</button>
          </div>
        </div>
      </form>
      
      <?php else: ?>
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="fw-bold">MCE Records (4-Year Terms)</h5></div>
        <a href="mce-manage.php?action=new" class="adm-btn adm-btn-primary">+ Add New MCE</a>
      </div>
      
      <div class="row g-3">
        <?php foreach ($mces as $mce): ?>
        <div class="col-md-6 col-lg-4">
          <div class="adm-card h-100 <?= $mce['is_active'] ? 'border-primary' : '' ?>">
            <div class="p-3">
              <div class="d-flex align-items-start gap-3 mb-3">
                <img src="assets/img/profileImg/<?= $mce['image'] ?: 'mce.jpg' ?>" class="rounded-circle" style="width:70px;height:70px;object-fit:cover;">
                <div class="flex-grow-1">
                  <h6 class="fw-bold mb-1"><?= htmlspecialchars($mce['first_name'] . ' ' . $mce['last_name']) ?></h6>
                  <p class="text-muted small mb-1"><?= htmlspecialchars($mce['title']) ?></p>
                  <small class="text-muted">Term: <?= date('Y', strtotime($mce['term_start'])) ?> - <?= $mce['term_end'] ? date('Y', strtotime($mce['term_end'])) : 'Present' ?></small>
                  <?php if ($mce['is_active']): ?>
                    <span class="badge bg-success ms-2">Current</span>
                  <?php endif; ?>
                </div>
              </div>
              <p class="text-muted small mb-3" style="height:60px;overflow:hidden;"><?= htmlspecialchars(substr($mce['biography'] ?? '', 0, 100)) ?><?= strlen($mce['biography'] ?? '') > 100 ? '...' : '' ?></p>
              <div class="d-flex gap-2 flex-wrap">
                <a href="mce-manage.php?action=edit&id=<?= $mce['id'] ?>" class="adm-btn adm-btn-sm adm-btn-outline">Edit</a>
                <?php if (!$mce['is_active']): ?>
                <form method="POST" class="d-inline">
                  <input type="hidden" name="form_action" value="activate">
                  <input type="hidden" name="activate_id" value="<?= $mce['id'] ?>">
                  <button type="submit" class="adm-btn adm-btn-sm adm-btn-success" onclick="return confirm('Set this as the current MCE?');">Set Active</button>
                </form>
                <?php endif; ?>
                <form method="POST" class="d-inline" onsubmit="return confirm('Delete this MCE record?');">
                  <input type="hidden" name="form_action" value="delete">
                  <input type="hidden" name="delete_id" value="<?= $mce['id'] ?>">
                  <button type="submit" class="adm-btn adm-btn-sm adm-btn-danger">Delete</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
        
        <?php if (empty($mces)): ?>
        <div class="col-12">
          <div class="adm-card p-5 text-center">
            <i class="bi bi-person-badge fs-1 text-muted mb-3"></i>
            <h6>No MCE Records</h6>
            <p class="text-muted small">Add the current Municipal Chief Executive to get started.</p>
            <a href="mce-manage.php?action=new" class="adm-btn adm-btn-primary mt-2">Add First MCE</a>
          </div>
        </div>
        <?php endif; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
