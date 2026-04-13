<?php
require_once __DIR__ . '/../src/init.php';
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

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

// Handle POST requests
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
            header('Location: mce-manage.php?msg=MCE record deleted successfully!');
            exit;
        }
    }

    // Handle Set Active
    if ($formAction === 'activate') {
        $activateId = (int)($_POST['activate_id'] ?? 0);
        if ($activateId) {
            $mceModel->setActive($activateId);
            header('Location: mce-manage.php?msg=MCE set as current successfully!');
            exit;
        }
    }

    // Handle Save/Create
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

        // Validation
        $errors = [];
        if (empty($firstName)) $errors[] = 'First name is required';
        if (empty($lastName)) $errors[] = 'Last name is required';
        if ($isActive && empty($termStart)) $errors[] = 'Term start date is required for active MCE';

        if (empty($errors)) {
            // Image upload
            $image = $_POST['existing_image'] ?? '';
            if (!empty($_FILES['mce_image']['name'])) {
                $ext = strtolower(pathinfo($_FILES['mce_image']['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                if (in_array($ext, $allowed)) {
                    $image = 'mce_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
                    move_uploaded_file($_FILES['mce_image']['tmp_name'], $mceImgPath . $image);
                } else {
                    $errors[] = 'Invalid image format. Only JPG, PNG, GIF allowed.';
                }
            }

            if (empty($errors)) {
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

                $savedId = $mceModel->save($data);

                if ($savedId) {
                    // If this is set as active, deactivate others
                    if ($isActive) {
                        $mceModel->setActive($savedId);
                    }

                    $msg = $id ? 'MCE updated successfully!' : 'New MCE added successfully!';
                    header('Location: mce-manage.php?msg=' . urlencode($msg));
                    exit;
                } else {
                    $msg = 'Error saving MCE record.';
                }
            }
        }

        if (!empty($errors)) {
            $msg = 'Errors: ' . implode(', ', $errors);
        }
    }
}

// Load data for edit mode
if ($action === 'edit' && $editId) {
    $item = $mceModel->getById($editId);
    if (!$item) {
        header('Location: mce-manage.php?msg=MCE not found');
        exit;
    }
}

$mces = $mceModel->getAllMces();
$currentPage = 'MCE Management';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage MCE – NJSMA Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/admin.css">
    <style>
        .mce-card { transition: all 0.3s ease; }
        .mce-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .current-mce { border: 2px solid #0d6efd; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); }
    </style>
</head>
<body>
    <?php include __DIR__ . '/partials/sidebar.php'; ?>
    <div class="adm-main">
        <?php include __DIR__ . '/partials/header.php'; ?>
        <div class="adm-content">
            <?php if ($msg): ?>
                <div class="adm-alert adm-alert-<?= strpos($msg, 'Error') !== false || strpos($msg, 'Errors') !== false ? 'danger' : 'success' ?>">
                    <i class="bi bi-<?= strpos($msg, 'Error') !== false || strpos($msg, 'Errors') !== false ? 'exclamation-triangle' : 'check-circle' ?>-fill"></i>
                    <?= htmlspecialchars($msg) ?>
                </div>
            <?php endif; ?>

            <?php if ($action === 'new' || $action === 'edit'): ?>
                <!-- Edit/New Form -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold mb-1">
                            <i class="bi bi-award text-primary me-2"></i>
                            <?= $item ? 'Edit MCE' : 'Add New MCE' ?>
                        </h5>
                        <small class="text-muted">Manage Municipal Chief Executive information</small>
                    </div>
                    <a href="mce-manage.php" class="adm-btn adm-btn-outline">
                        <i class="bi bi-arrow-left me-1"></i>Back to List
                    </a>
                </div>

                <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <input type="hidden" name="form_action" value="save">
                    <input type="hidden" name="id" value="<?= $item['id'] ?? '' ?>">
                    <input type="hidden" name="existing_image" value="<?= $item['image'] ?? '' ?>">

                    <div class="row g-4">
                        <!-- Personal Information -->
                        <div class="col-lg-8">
                            <div class="adm-card p-4 mb-4">
                                <h6 class="fw-bold mb-4 text-primary">
                                    <i class="bi bi-person-fill me-2"></i>Personal Information
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="adm-form-label">First Name *</label>
                                        <input type="text" name="first_name" class="adm-form-control" required
                                               value="<?= htmlspecialchars($item['first_name'] ?? '') ?>">
                                        <div class="invalid-feedback">First name is required.</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="adm-form-label">Last Name *</label>
                                        <input type="text" name="last_name" class="adm-form-control" required
                                               value="<?= htmlspecialchars($item['last_name'] ?? '') ?>">
                                        <div class="invalid-feedback">Last name is required.</div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="adm-form-label">Title</label>
                                    <input type="text" name="title" class="adm-form-control"
                                           value="<?= htmlspecialchars($item['title'] ?? 'Municipal Chief Executive') ?>">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="adm-form-label">Email</label>
                                        <input type="email" name="email" class="adm-form-control"
                                               value="<?= htmlspecialchars($item['email'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="adm-form-label">Phone</label>
                                        <input type="tel" name="phone" class="adm-form-control"
                                               value="<?= htmlspecialchars($item['phone'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="adm-form-label">Public Contact Email</label>
                                    <input type="email" name="contact_email" class="adm-form-control"
                                           value="<?= htmlspecialchars($item['contact_email'] ?? '') ?>">
                                    <small class="text-muted">Email displayed on the public MCE profile page</small>
                                </div>
                            </div>

                            <!-- Biography & Vision -->
                            <div class="adm-card p-4 mb-4">
                                <h6 class="fw-bold mb-4 text-primary">
                                    <i class="bi bi-file-text me-2"></i>Biography & Vision
                                </h6>
                                <div class="mb-3">
                                    <label class="adm-form-label">Biography</label>
                                    <textarea name="biography" rows="4" class="adm-form-control"
                                              placeholder="Detailed biography of the MCE..."><?= htmlspecialchars($item['biography'] ?? '') ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="adm-form-label">Vision Statement</label>
                                    <textarea name="vision" rows="3" class="adm-form-control"
                                              placeholder="MCE's vision for the municipality..."><?= htmlspecialchars($item['vision'] ?? '') ?></textarea>
                                </div>
                                <div class="mb-0">
                                    <label class="adm-form-label">Education & Background</label>
                                    <textarea name="education" rows="3" class="adm-form-control"
                                              placeholder="Educational qualifications and background..."><?= htmlspecialchars($item['education'] ?? '') ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="col-lg-4">
                            <!-- Profile Photo -->
                            <div class="adm-card p-4 mb-4">
                                <h6 class="fw-bold mb-4 text-primary">
                                    <i class="bi bi-camera me-2"></i>Profile Photo
                                </h6>
                                <?php if(!empty($item['image']) && file_exists($mceImgPath . $item['image'])): ?>
                                    <div class="text-center mb-3">
                                        <img src="assets/img/profileImg/<?= $item['image'] ?>" class="img-fluid rounded shadow-sm"
                                             style="max-height: 200px; object-fit: cover;" alt="Current photo">
                                    </div>
                                <?php else: ?>
                                    <div class="text-center mb-3">
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                             style="height: 150px;">
                                            <i class="bi bi-person-circle fs-1 text-muted"></i>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="mce_image" class="adm-form-control" accept="image/*">
                                <small class="text-muted">Upload a professional photo (JPG, PNG, GIF)</small>
                            </div>

                            <!-- Term Information -->
                            <div class="adm-card p-4 mb-4">
                                <h6 class="fw-bold mb-4 text-primary">
                                    <i class="bi bi-calendar-event me-2"></i>Term Information
                                </h6>
                                <div class="mb-3">
                                    <label class="adm-form-label">Term Start Date *</label>
                                    <input type="date" name="term_start" class="adm-form-control" required
                                           value="<?= $item['term_start'] ?? date('Y-m-d') ?>">
                                    <div class="invalid-feedback">Term start date is required.</div>
                                </div>
                                <div class="mb-3">
                                    <label class="adm-form-label">Term End Date</label>
                                    <input type="date" name="term_end" class="adm-form-control"
                                           value="<?= $item['term_end'] ?? '' ?>">
                                    <small class="text-muted">Leave empty if ongoing term</small>
                                </div>
                                <div class="form-check mb-0">
                                    <input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1"
                                           <?= ($item['is_active'] ?? 0) ? 'checked' : '' ?>>
                                    <label class="form-check-label fw-bold" for="isActive">
                                        Set as Current MCE
                                    </label>
                                    <small class="text-muted d-block">Only one MCE can be active at a time</small>
                                </div>
                            </div>

                            <!-- Social Media -->
                            <div class="adm-card p-4 mb-4">
                                <h6 class="fw-bold mb-4 text-primary">
                                    <i class="bi bi-share me-2"></i>Social Media Links
                                </h6>
                                <div class="mb-3">
                                    <label class="adm-form-label">
                                        <i class="bi bi-facebook text-primary me-1"></i>Facebook
                                    </label>
                                    <input type="url" name="social_facebook" class="adm-form-control"
                                           value="<?= htmlspecialchars($item['social_facebook'] ?? '') ?>"
                                           placeholder="https://facebook.com/...">
                                </div>
                                <div class="mb-3">
                                    <label class="adm-form-label">
                                        <i class="bi bi-twitter-x text-info me-1"></i>Twitter/X
                                    </label>
                                    <input type="url" name="social_twitter" class="adm-form-control"
                                           value="<?= htmlspecialchars($item['social_twitter'] ?? '') ?>"
                                           placeholder="https://twitter.com/...">
                                </div>
                                <div class="mb-0">
                                    <label class="adm-form-label">
                                        <i class="bi bi-linkedin text-primary me-1"></i>LinkedIn
                                    </label>
                                    <input type="url" name="social_linkedin" class="adm-form-control"
                                           value="<?= htmlspecialchars($item['social_linkedin'] ?? '') ?>"
                                           placeholder="https://linkedin.com/...">
                                </div>
                            </div>

                            <!-- Save Button -->
                            <button type="submit" class="adm-btn adm-btn-primary w-100 mb-3">
                                <i class="bi bi-check-lg me-2"></i>
                                <?= $item ? 'Update MCE' : 'Save New MCE' ?>
                            </button>
                        </div>
                    </div>
                </form>

            <?php else: ?>
                <!-- List View -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold mb-1">
                            <i class="bi bi-award text-primary me-2"></i>MCE Management
                        </h5>
                        <small class="text-muted">Manage Municipal Chief Executives and their terms</small>
                    </div>
                    <a href="mce-manage.php?action=new" class="adm-btn adm-btn-primary">
                        <i class="bi bi-plus-lg me-1"></i>Add New MCE
                    </a>
                </div>

                <div class="row g-4">
                    <?php foreach ($mces as $mce): ?>
                        <div class="col-lg-6 col-xl-4">
                            <div class="adm-card h-100 mce-card <?= $mce['is_active'] ? 'current-mce' : '' ?>">
                                <div class="p-4">
                                    <div class="d-flex align-items-start gap-3 mb-3">
                                        <img src="assets/img/profileImg/<?= $mce['image'] ?: 'mce.jpg' ?>"
                                             class="rounded-circle border"
                                             style="width: 60px; height: 60px; object-fit: cover;"
                                             alt="Profile photo">
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold mb-1">
                                                <?= htmlspecialchars($mce['first_name'] . ' ' . $mce['last_name']) ?>
                                                <?php if ($mce['is_active']): ?>
                                                    <span class="badge bg-primary ms-2">Current</span>
                                                <?php endif; ?>
                                            </h6>
                                            <p class="text-muted small mb-1"><?= htmlspecialchars($mce['title']) ?></p>
                                            <small class="text-muted">
                                                Term: <?= date('M Y', strtotime($mce['term_start'])) ?> -
                                                <?= $mce['term_end'] ? date('M Y', strtotime($mce['term_end'])) : 'Present' ?>
                                            </small>
                                        </div>
                                    </div>

                                    <?php if (!empty($mce['biography'])): ?>
                                        <p class="text-muted small mb-3" style="height: 40px; overflow: hidden;">
                                            <?= htmlspecialchars(substr($mce['biography'], 0, 80)) ?>
                                            <?= strlen($mce['biography']) > 80 ? '...' : '' ?>
                                        </p>
                                    <?php endif; ?>

                                    <div class="d-flex gap-2 flex-wrap">
                                        <a href="mce-manage.php?action=edit&id=<?= $mce['id'] ?>"
                                           class="adm-btn adm-btn-sm adm-btn-outline">
                                            <i class="bi bi-pencil me-1"></i>Edit
                                        </a>

                                        <?php if (!$mce['is_active']): ?>
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="form_action" value="activate">
                                                <input type="hidden" name="activate_id" value="<?= $mce['id'] ?>">
                                                <button type="submit" class="adm-btn adm-btn-sm adm-btn-success"
                                                        onclick="return confirm('Set this as the current MCE? This will deactivate all others.');">
                                                    <i class="bi bi-star me-1"></i>Set Active
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <form method="POST" class="d-inline" onsubmit="return confirm('Delete this MCE record? This action cannot be undone.');">
                                            <input type="hidden" name="form_action" value="delete">
                                            <input type="hidden" name="delete_id" value="<?= $mce['id'] ?>">
                                            <button type="submit" class="adm-btn adm-btn-sm adm-btn-danger">
                                                <i class="bi bi-trash me-1"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <?php if (empty($mces)): ?>
                        <div class="col-12">
                            <div class="adm-card p-5 text-center">
                                <i class="bi bi-award fs-1 text-muted mb-3"></i>
                                <h6 class="fw-bold text-muted mb-2">No MCE Records</h6>
                                <p class="text-muted mb-4">Add the current Municipal Chief Executive to get started.</p>
                                <a href="mce-manage.php?action=new" class="adm-btn adm-btn-primary">
                                    <i class="bi bi-plus-lg me-1"></i>Add First MCE
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form validation
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.adm-alert');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);
    </script>
</body>
</html>
