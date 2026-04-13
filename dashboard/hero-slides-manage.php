<?php
/**
 * Hero Slides Management Page
 */

require_once __DIR__ . '/../src/init.php';

use Models\HeroSlide;

if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$slideModel = new HeroSlide();
$currentPage = 'Manage Hero Slides';

$message = '';
$error = '';

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($slideModel->delete($id)) {
        $message = 'Slide deleted successfully.';
    } else {
        $error = 'Failed to delete slide.';
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
    $data = [
        'title' => trim($_POST['title'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'image' => trim($_POST['image'] ?? 'slider-1.jpg'),
        'badge' => trim($_POST['badge'] ?? ''),
        'badge_class' => trim($_POST['badge_class'] ?? 'bg-primary'),
        'button_1_text' => trim($_POST['button_1_text'] ?? ''),
        'button_1_link' => trim($_POST['button_1_link'] ?? ''),
        'button_2_text' => trim($_POST['button_2_text'] ?? ''),
        'button_2_link' => trim($_POST['button_2_link'] ?? ''),
        'is_active' => isset($_POST['is_active']) ? 1 : 0,
        'display_order' => (int)($_POST['display_order'] ?? 0)
    ];

    if (empty($data['title'])) {
        $error = 'Slide title is required.';
    } else {
        if ($id) {
            if ($slideModel->update($id, $data)) {
                $message = 'Slide updated successfully.';
            } else {
                $error = 'Failed to update slide.';
            }
        } else {
            if ($slideModel->create($data)) {
                $message = 'Slide created successfully.';
            } else {
                $error = 'Failed to create slide.';
            }
        }
    }
}

$slides = $slideModel->getAll();

$editSlide = null;
if (isset($_GET['edit'])) {
    $editSlide = $slideModel->getById((int)$_GET['edit']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Hero Slides — NJSMA Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
  <?php include __DIR__ . '/partials/sidebar.php'; ?>
  <div class="adm-main">
    <?php include __DIR__ . '/partials/header.php'; ?>
    <div class="adm-content">
      <div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Manage Hero Slides</h1>
    </div>

    <?php if ($message): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($error) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="row">
        <!-- Slides List -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Current Slides</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Order</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($slides as $slide): ?>
                                <tr>
                                    <td><?= $slide['display_order'] ?? 0 ?></td>
                                    <td><img src="/njsma/dashboard/assets/img/heroImg/<?= htmlspecialchars($slide['image'] ?? 'slider-1.jpg') ?>" alt="" style="width: 60px; height: 40px; object-fit: cover;"></td>
                                    <td><?= htmlspecialchars(strip_tags($slide['title'])) ?></td>
                                    <td>
                                        <?php if ($slide['is_active']): ?>
                                        <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="?edit=<?= $slide['id'] ?>" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="?delete=<?= $slide['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this slide?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add/Edit Slide Form -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0"><?= $editSlide ? 'Edit Slide' : 'Add New Slide' ?></h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <?php if ($editSlide): ?>
                        <input type="hidden" name="id" value="<?= $editSlide['id'] ?>">
                        <?php endif; ?>
                        <div class="mb-3">
                            <label class="form-label">Title *</label>
                            <input type="text" name="title" class="form-control" required 
                                   value="<?= htmlspecialchars($editSlide['title'] ?? '') ?>">
                            <small class="text-muted">Use &lt;span&gt;text&lt;/span&gt; for highlighted text</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($editSlide['description'] ?? '') ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image Filename</label>
                            <input type="text" name="image" class="form-control" 
                                   value="<?= htmlspecialchars($editSlide['image'] ?? 'slider-1.jpg') ?>" placeholder="e.g., slider-1.jpg">
                            <small class="text-muted">Upload to dashboard/assets/img/heroImg/</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Badge Text</label>
                            <input type="text" name="badge" class="form-control" 
                                   value="<?= htmlspecialchars($editSlide['badge'] ?? '') ?>" placeholder="e.g., Official Municipal Website">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Badge Style</label>
                            <select name="badge_class" class="form-select">
                                <option value="bg-primary" <?= ($editSlide['badge_class'] ?? '') === 'bg-primary' ? 'selected' : '' ?>>Primary (Blue)</option>
                                <option value="bg-secondary" <?= ($editSlide['badge_class'] ?? '') === 'bg-secondary' ? 'selected' : '' ?>>Secondary (Gray)</option>
                                <option value="bg-success" <?= ($editSlide['badge_class'] ?? '') === 'bg-success' ? 'selected' : '' ?>>Success (Green)</option>
                                <option value="bg-warning" <?= ($editSlide['badge_class'] ?? '') === 'bg-warning' ? 'selected' : '' ?>>Warning (Yellow)</option>
                                <option value="bg-danger" <?= ($editSlide['badge_class'] ?? '') === 'bg-danger' ? 'selected' : '' ?>>Danger (Red)</option>
                                <option value="bg-info" <?= ($editSlide['badge_class'] ?? '') === 'bg-info' ? 'selected' : '' ?>>Info (Cyan)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Primary Button</label>
                            <div class="row">
                                <div class="col-6"><input type="text" name="button_1_text" class="form-control" placeholder="Text" value="<?= htmlspecialchars($editSlide['button_1_text'] ?? '') ?>"></div>
                                <div class="col-6"><input type="text" name="button_1_link" class="form-control" placeholder="Link" value="<?= htmlspecialchars($editSlide['button_1_link'] ?? '') ?>"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Secondary Button</label>
                            <div class="row">
                                <div class="col-6"><input type="text" name="button_2_text" class="form-control" placeholder="Text" value="<?= htmlspecialchars($editSlide['button_2_text'] ?? '') ?>"></div>
                                <div class="col-6"><input type="text" name="button_2_link" class="form-control" placeholder="Link" value="<?= htmlspecialchars($editSlide['button_2_link'] ?? '') ?>"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Display Order</label>
                            <input type="number" name="display_order" class="form-control" 
                                   value="<?= $editSlide['display_order'] ?? 0 ?>">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" 
                                       <?= ($editSlide['is_active'] ?? 1) ? 'checked' : '' ?>>
                                <label class="form-check-label">Active</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-<?= $editSlide ? 'check-lg' : 'plus-lg' ?> me-2"></i><?= $editSlide ? 'Save Changes' : 'Add Slide' ?>
                        </button>
                        <?php if ($editSlide): ?>
                        <a href="hero-slides-manage.php" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
  </div>
</body>
</html>
