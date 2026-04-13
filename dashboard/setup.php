<?php
/**
 * Admin Setup Page - First Time Setup Only
 * This page creates the first admin account
 * After setup, this file should be deleted for security
 */

require_once __DIR__ . '/../src/init.php';

use Models\Admin;

$adminModel = new Admin();

// If admin already exists, redirect to login
if ($adminModel->adminExists()) {
    header('Location: login.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $fullName = trim($_POST['full_name'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (empty($username) || empty($email) || empty($password)) {
        $error = 'All fields are required.';
    } elseif (strlen($username) < 4) {
        $error = 'Username must be at least 4 characters.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match.';
    } else {
        try {
            $adminModel->create([
                'username' => $username,
                'email' => $email,
                'full_name' => $fullName,
                'password' => $password,
                'is_active' => 1
            ]);
            
            $success = 'Admin account created successfully! You can now login.';
            
            // Optional: Auto-login after setup
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $adminModel->getByUsername($username)['id'];
            $_SESSION['admin_username'] = $username;
            $_SESSION['admin_full_name'] = $fullName;
            
            // Redirect after 2 seconds
            header('Refresh: 2; URL=index.php');
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Setup — NJSMA</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
        font-family: 'Inter', sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #0d1f16 0%, #056839 60%, #0a9952 100%);
    }
    .setup-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 30px 80px rgba(0,0,0,0.25);
        overflow: hidden;
        max-width: 600px;
        width: 100%;
        margin: 20px auto;
    }
    .setup-header {
        background: linear-gradient(135deg, #056839, #0a9952);
        color: #fff;
        padding: 40px;
        text-align: center;
    }
    .setup-header h1 {
        font-weight: 800;
        font-size: 28px;
        margin-bottom: 10px;
    }
    .setup-header p {
        opacity: 0.9;
        margin-bottom: 0;
    }
    .setup-body {
        padding: 40px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-label {
        font-weight: 600;
        font-size: 14px;
        color: #333;
        margin-bottom: 8px;
        display: block;
    }
    .form-control {
        padding: 12px 16px;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.2s;
    }
    .form-control:focus {
        border-color: #056839;
        box-shadow: 0 0 0 3px rgba(5,104,57,0.12);
    }
    .btn-setup {
        width: 100%;
        padding: 14px;
        background: #056839;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-setup:hover {
        background: #044828;
    }
    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 14px;
        margin-bottom: 20px;
    }
    .alert-danger {
        background: #ffebee;
        color: #c62828;
        border: 1px solid #ef9a9a;
    }
    .alert-success {
        background: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #a5d6a7;
    }
    .warning-box {
        background: #fff3e0;
        border-left: 4px solid #ff9800;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 0 8px 8px 0;
    }
    .warning-box i {
        color: #ff9800;
        margin-right: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="setup-card">
      <div class="setup-header">
        <i class="bi bi-shield-lock-fill" style="font-size: 48px; margin-bottom: 15px; display: block;"></i>
        <h1>Admin Setup</h1>
        <p>Create your first administrator account</p>
      </div>
      
      <div class="setup-body">
        <div class="warning-box">
          <i class="bi bi-exclamation-triangle-fill"></i>
          <strong>Important:</strong> This page should be deleted after creating the first admin account.
        </div>

        <?php if ($error): ?>
        <div class="alert alert-danger">
          <i class="bi bi-exclamation-circle-fill me-2"></i><?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>

        <?php if ($success): ?>
        <div class="alert alert-success">
          <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($success) ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="">
          <div class="form-group">
            <label class="form-label">Username *</label>
            <input type="text" name="username" class="form-control" required 
                   minlength="4" placeholder="Enter username (min 4 characters)"
                   value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
          </div>

          <div class="form-group">
            <label class="form-label">Email Address *</label>
            <input type="email" name="email" class="form-control" required 
                   placeholder="Enter email address"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
          </div>

          <div class="form-group">
            <label class="form-label">Full Name</label>
            <input type="text" name="full_name" class="form-control" 
                   placeholder="Enter full name (optional)"
                   value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>">
          </div>

          <div class="form-group">
            <label class="form-label">Password *</label>
            <input type="password" name="password" class="form-control" required 
                   minlength="8" placeholder="Enter password (min 8 characters)">
            <small class="text-muted">Must be at least 8 characters</small>
          </div>

          <div class="form-group">
            <label class="form-label">Confirm Password *</label>
            <input type="password" name="confirm_password" class="form-control" required 
                   minlength="8" placeholder="Confirm your password">
          </div>

          <button type="submit" class="btn-setup">
            <i class="bi bi-person-plus me-2"></i>Create Admin Account
          </button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
