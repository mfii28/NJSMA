<?php
/**
 * Admin Forgot Password Page
 */

require_once __DIR__ . '/../src/init.php';

use Models\Admin;

$adminModel = new Admin();

// Redirect if already logged in
if (!empty($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        $token = $adminModel->createPasswordResetToken($email);
        
        if ($token) {
            // In production, send email with reset link
            // For now, show the link directly (development mode)
            $resetLink = SITE_URL . '/dashboard/reset-password.php?token=' . $token;
            $success = 'Password reset link has been generated. <br><br><a href="' . htmlspecialchars($resetLink) . '">Click here to reset your password</a>';
        } else {
            // Don't reveal if email exists or not (security)
            $success = 'If this email exists in our system, you will receive a password reset link.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password — NJSMA</title>
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
        max-width: 460px;
        width: 100%;
        margin: 20px auto;
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
    .adm-alert-success { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
    .back-link { text-align: center; margin-top: 20px; }
    .back-link a { color: #056839; text-decoration: none; font-weight: 600; }
    .back-link a:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <div class="container">
    <div class="login-card mx-auto">
      <div class="login-left">
        <div class="text-center mb-4">
          <div class="login-brand-text">NJSMA<span>.</span></div>
          <div class="login-subtitle">New Juaben South Municipal Assembly</div>
        </div>

        <h2 class="login-heading">Forgot Password?</h2>
        <p class="login-desc">Enter your email address to receive a password reset link.</p>

        <?php if ($error): ?>
        <div class="adm-alert"><i class="bi bi-exclamation-triangle-fill"></i><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
        <div class="adm-alert adm-alert-success"><i class="bi bi-check-circle-fill"></i><?= $success ?></div>
        <?php else: ?>

        <form method="POST" action="">
          <div class="inp-group">
            <i class="bi bi-envelope-fill inp-icon"></i>
            <input type="email" name="email" class="inp" placeholder="Enter your email" required 
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
          </div>

          <button type="submit" class="btn-login">
            <i class="bi bi-send"></i> Send Reset Link
          </button>
        </form>

        <?php endif; ?>

        <div class="back-link">
          <a href="login.php"><i class="bi bi-arrow-left me-1"></i> Back to Login</a>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
