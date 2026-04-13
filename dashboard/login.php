<?php
/**
 * Admin Login Page
 * Uses secure Admin model for authentication
 */

require_once __DIR__ . '/../src/init.php';

use Models\Admin;

// Redirect if already logged in
if (!empty($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

$adminModel = new Admin();

// Check if first-time setup is needed
if (!$adminModel->adminExists()) {
    header('Location: setup.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    $admin = $adminModel->verify($username, $password);
    
    if ($admin) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['admin_full_name'] = $admin['full_name'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login — NJSMA</title>
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
    .login-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 30px 80px rgba(0,0,0,0.25);
        overflow: hidden;
        max-width: 920px;
        width: 100%;
    }
    .login-left {
        padding: 50px 44px;
    }
    .login-brand-text { font-size: 28px; font-weight: 800; color: #056839; }
    .login-brand-text span { color: #F8CF2E; }
    .login-subtitle { color: #888; font-size: 13px; margin-top: 2px; }
    .login-heading { font-size: 26px; font-weight: 800; color: #1a1a2e; margin-top: 36px; margin-bottom: 4px; }
    .login-desc { color: #999; font-size: 14px; margin-bottom: 28px;}
    .inp-group { position: relative; margin-bottom: 18px; }
    .inp-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #aaa; font-size: 16px; }
    .inp { width: 100%; padding: 12px 14px 12px 42px; border: 1.5px solid #e0e0e0; border-radius: 10px; font-size: 14px; transition: all 0.2s; outline: none; font-family: inherit; }
    .inp:focus { border-color: #056839; box-shadow: 0 0 0 3px rgba(5,104,57,0.12); }
    .btn-login { width: 100%; padding: 13px; background: #056839; color: #fff; border: none; border-radius: 10px; font-size: 15px; font-weight: 700; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px; }
    .btn-login:hover { background: #044828; }
    .adm-alert { padding: 12px 16px; border-radius: 8px; font-size: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; background: #ffebee; color: #c62828; border: 1px solid #ef9a9a; }
    .login-right {
        background: linear-gradient(160deg, #056839, #0a9952);
        color: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 50px 36px;
        text-align: center;
    }
    .login-right .icon-hero { font-size: 64px; margin-bottom: 20px; opacity: 0.85; }
    .login-right h3 { font-weight: 800; font-size: 22px; margin-bottom: 12px; }
    .login-right p { font-size: 13px; opacity: 0.75; line-height: 1.7; }
    .btn-outline-light-custom { display: inline-block; padding: 10px 24px; border: 1.5px solid rgba(255,255,255,0.6); border-radius: 30px; color: #fff; font-weight: 600; font-size: 13px; margin-top: 24px; transition: all 0.2s; }
    .btn-outline-light-custom:hover { background: rgba(255,255,255,0.15); }
  </style>
</head>
<body>
  <div class="container">
    <div class="login-card mx-auto">
      <div class="row g-0">
        <div class="col-lg-6 login-left">
          <div class="login-brand-text">NJSMA<span>.</span></div>
          <div class="login-subtitle">New Juaben South Municipal Assembly</div>

          <h2 class="login-heading">Welcome Back</h2>
          <p class="login-desc">Sign in to your administrator account to manage your site.</p>

          <?php if ($error): ?>
          <div class="adm-alert"><i class="bi bi-exclamation-triangle-fill"></i><?= $error ?></div>
          <?php endif; ?>

          <form method="POST" action="">
            <div class="inp-group">
              <i class="bi bi-person-fill inp-icon"></i>
              <input type="text" name="username" class="inp" placeholder="Username" required autocomplete="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
            </div>
            <div class="inp-group">
              <i class="bi bi-lock-fill inp-icon"></i>
              <input type="password" name="password" class="inp" placeholder="Password" required autocomplete="current-password">
            </div>
            <div class="mb-4"></div>
            <button type="submit" class="btn-login">
              Sign In <i class="bi bi-arrow-right"></i>
            </button>
          </form>

          <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="forgot-password.php" class="text-muted small text-decoration-none">Forgot password?</a>
            <span class="text-muted small">Need help? Contact IT</span>
          </div>
        </div>
        <div class="col-lg-6 login-right d-none d-lg-flex">
          <div class="icon-hero">🏛️</div>
          <h3>Secure Admin Portal</h3>
          <p>Manage your municipal website's content, departments, news, tenders, and global settings – all in one place.</p>
          <a href="<?= SITE_URL ?>/" target="_blank" class="btn-outline-light-custom">
            <i class="bi bi-box-arrow-up-right me-1"></i> View Public Site
          </a>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
