<?php
/**
 * Services Management Page
 */

require_once __DIR__ . '/../src/init.php';

use Models\Service;

if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$serviceModel = new Service();
$currentPage = 'Manage Services';

$message = '';
$error = '';

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($serviceModel->delete($id)) {
        $message = 'Service deleted successfully.';
    } else {
        $error = 'Failed to delete service.';
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
    $data = [
        'title' => trim($_POST['title'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'icon' => trim($_POST['icon'] ?? 'bi-briefcase'),
        'link' => trim($_POST['link'] ?? ''),
        'link_text' => trim($_POST['link_text'] ?? 'Learn More'),
        'is_active' => isset($_POST['is_active']) ? 1 : 0,
        'display_order' => (int)($_POST['display_order'] ?? 0)
    ];

    if (empty($data['title'])) {
        $error = 'Service title is required.';
    } else {
        if ($id) {
            if ($serviceModel->update($id, $data)) {
                $message = 'Service updated successfully.';
            } else {
                $error = 'Failed to update service.';
            }
        } else {
            if ($serviceModel->create($data)) {
                $message = 'Service created successfully.';
            } else {
                $error = 'Failed to create service.';
            }
        }
    }
}

$editService = null;
if (isset($_GET['edit'])) {
    $editService = $serviceModel->getById((int)$_GET['edit']);
}

$services = $serviceModel->getAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Services — NJSMA Admin</title>
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
        <h1 class="h3 mb-0"><?= $editService ? 'Edit Service' : 'Manage Services' ?></h1>
        <?php if ($editService): ?>
        <a href="services-manage.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
        <?php endif; ?>
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
        <?php if (!$editService): ?>
        <!-- Services List -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">All Services</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Order</th>
                                    <th>Icon</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($services as $service): ?>
                                <tr>
                                    <td><?= $service['display_order'] ?></td>
                                    <td><i class="bi <?= htmlspecialchars($service['icon']) ?>"></i></td>
                                    <td><?= htmlspecialchars($service['title']) ?></td>
                                    <td>
                                        <?php if ($service['is_active']): ?>
                                        <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="?edit=<?= $service['id'] ?>" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="?delete=<?= $service['id'] ?>" class="btn btn-sm btn-outline-danger" 
                                           onclick="return confirm('Are you sure you want to delete this service?')">
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

        <!-- Add New Service Form -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Add New Service</h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Title *</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Icon (Bootstrap Icon class)</label>
                            <input type="text" name="icon" class="form-control" value="bi-briefcase" placeholder="e.g., bi-briefcase, bi-building">
                            <small class="text-muted">Find icons at: https://icons.getbootstrap.com</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Link URL</label>
                            <input type="text" name="link" class="form-control" placeholder="/njsma/service-charter">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Link Text</label>
                            <input type="text" name="link_text" class="form-control" value="Learn More">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Display Order</label>
                            <input type="number" name="display_order" class="form-control" value="0">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" checked>
                                <label class="form-check-label">Active</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-plus-lg me-2"></i>Add Service
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php else: ?>
        <!-- Edit Service Form -->
        <div class="col-lg-6 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Edit Service</h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $editService['id'] ?>">
                        <div class="mb-3">
                            <label class="form-label">Title *</label>
                            <input type="text" name="title" class="form-control" required 
                                   value="<?= htmlspecialchars($editService['title']) ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($editService['description']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Icon (Bootstrap Icon class)</label>
                            <input type="text" name="icon" class="form-control" 
                                   value="<?= htmlspecialchars($editService['icon']) ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Link URL</label>
                            <input type="text" name="link" class="form-control" 
                                   value="<?= htmlspecialchars($editService['link']) ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Link Text</label>
                            <input type="text" name="link_text" class="form-control" 
                                   value="<?= htmlspecialchars($editService['link_text']) ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Display Order</label>
                            <input type="number" name="display_order" class="form-control" 
                                   value="<?= $editService['display_order'] ?>">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" 
                                       <?= $editService['is_active'] ? 'checked' : '' ?>>
                                <label class="form-check-label">Active</label>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success flex-fill">
                                <i class="bi bi-check-lg me-2"></i>Save Changes
                            </button>
                            <a href="services-manage.php" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

    </div>
  </div>
</body>
</html>
