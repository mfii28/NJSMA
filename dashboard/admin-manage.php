<?php
/**
 * Admin User Management Page
 * Manage admin accounts - add, edit, delete
 */

require_once __DIR__ . '/../src/init.php';

use Models\Admin;

// Check authentication
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$adminModel = new Admin();
$error = '';
$success = '';
$editMode = false;
$editAdmin = null;

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    try {
        $adminModel->delete($id);
        header('Location: admin-manage.php?msg=deleted');
        exit;
    } catch (\Exception $e) {
        $error = $e->getMessage();
    }
}

// Check for edit mode
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $editAdmin = $adminModel->getById($id);
    if ($editAdmin) {
        $editMode = true;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $fullName = trim($_POST['full_name'] ?? '');
    $password = $_POST['password'] ?? '';
    $isActive = isset($_POST['is_active']) ? 1 : 0;
    
    // Validation
    if (empty($username) || empty($email)) {
        $error = 'Username and email are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (!$id && empty($password)) {
        $error = 'Password is required for new admin accounts.';
    } elseif (!$id && strlen($password) < 8) {
        $error = 'Password must be at least 8 characters.';
    } else {
        try {
            if ($id) {
                // Update existing admin
                $data = [
                    'username' => $username,
                    'email' => $email,
                    'full_name' => $fullName,
                    'is_active' => $isActive
                ];
                if (!empty($password)) {
                    if (strlen($password) < 8) {
                        $error = 'Password must be at least 8 characters.';
                    } else {
                        $data['password'] = $password;
                    }
                }
                if (empty($error)) {
                    $adminModel->update($id, $data);
                    header('Location: admin-manage.php?msg=updated');
                    exit;
                }
            } else {
                // Create new admin
                $adminModel->create([
                    'username' => $username,
                    'email' => $email,
                    'full_name' => $fullName,
                    'password' => $password,
                    'is_active' => $isActive
                ]);
                header('Location: admin-manage.php?msg=created');
                exit;
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }
    }
}

// Get all admins
$admins = $adminModel->getAll();

// Show success message from redirect
if (isset($_GET['msg'])) {
    switch ($_GET['msg']) {
        case 'created': $success = 'Admin account created successfully.'; break;
        case 'updated': $success = 'Admin account updated successfully.'; break;
        case 'deleted': $success = 'Admin account deleted successfully.'; break;
    }
}

$pageTitle = $editMode ? 'Edit Admin' : 'Manage Admins';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle) ?> — NJSMA Admin</title>
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
        <h1 class="h3 mb-0"><?= $editMode ? 'Edit Admin' : 'Admin Users' ?></h1>
        <?php if ($editMode): ?>
        <a href="admin-manage.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
        <?php endif; ?>
    </div>

    <?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($error) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($success) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="row">
        <?php if (!$editMode): ?>
        <!-- Admin List -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0">Admin Accounts</h5>
                    <span class="badge bg-secondary"><?= count($admins) ?> total</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Full Name</th>
                                    <th>Status</th>
                                    <th>Last Login</th>
                                    <th width="100">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($admins as $admin): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($admin['username']) ?></strong></td>
                                    <td><?= htmlspecialchars($admin['email']) ?></td>
                                    <td><?= htmlspecialchars($admin['full_name'] ?? '-') ?></td>
                                    <td>
                                        <?php if ($admin['is_active']): ?>
                                        <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                        <?php endif; ?>
                                        <?php if ($admin['username'] === $_SESSION['admin_username']): ?>
                                        <span class="badge bg-info">You</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $admin['last_login'] ? date('M d, Y H:i', strtotime($admin['last_login'])) : 'Never' ?></td>
                                    <td>
                                        <a href="?edit=<?= $admin['id'] ?>" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <?php if ($admin['username'] !== $_SESSION['admin_username'] && count($admins) > 1): ?>
                                        <a href="?delete=<?= $admin['id'] ?>" class="btn btn-sm btn-outline-danger" 
                                           onclick="return confirm('Are you sure you want to delete this admin account?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add New Admin Form -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Add New Admin</h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Username *</label>
                            <input type="text" name="username" class="form-control" required minlength="4">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="full_name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password *</label>
                            <input type="password" name="password" class="form-control" required minlength="8">
                            <small class="text-muted">Minimum 8 characters</small>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" checked>
                                <label class="form-check-label">Active</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-person-plus me-2"></i>Create Admin
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <?php else: ?>
        <!-- Edit Admin Form -->
        <div class="col-lg-6 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Edit Admin: <?= htmlspecialchars($editAdmin['username']) ?></h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $editAdmin['id'] ?>">
                        
                        <div class="mb-3">
                            <label class="form-label">Username *</label>
                            <input type="text" name="username" class="form-control" required minlength="4" 
                                   value="<?= htmlspecialchars($editAdmin['username']) ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control" required
                                   value="<?= htmlspecialchars($editAdmin['email']) ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="full_name" class="form-control"
                                   value="<?= htmlspecialchars($editAdmin['full_name'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control" minlength="8">
                            <small class="text-muted">Leave blank to keep current password. Minimum 8 characters.</small>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" 
                                       <?= $editAdmin['is_active'] ? 'checked' : '' ?>>
                                <label class="form-check-label">Active</label>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success flex-fill">
                                <i class="bi bi-check-lg me-2"></i>Save Changes
                            </button>
                            <a href="admin-manage.php" class="btn btn-outline-secondary">Cancel</a>
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
