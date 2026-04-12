<?php
require_once __DIR__ . '/../../src/init.php';
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: ' . SITE_URL . '/dashboard/login.php');
    exit;
}
$currentPage = $currentPage ?? 'Dashboard';
?>
<header class="adm-header">
  <button class="adm-toggle-btn" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
  <div>
    <div class="page-title"><?= htmlspecialchars($currentPage) ?></div>
    <div class="breadcrumb-sub">
      <a href="<?= SITE_URL ?>/dashboard/index.php" class="text-muted">Dashboard</a>
      <?php if ($currentPage !== 'Dashboard'): ?>  / <?= htmlspecialchars($currentPage) ?><?php endif; ?>
    </div>
  </div>
  <div class="adm-header-actions">
    <a href="<?= SITE_URL ?>/" target="_blank" class="btn-icon" title="View Site">
      <i class="bi bi-globe" style="font-size:16px;"></i>
    </a>
    <div class="dropdown">
      <div class="adm-user-chip" data-bs-toggle="dropdown">
        <div class="adm-avatar"><?= strtoupper(substr($_SESSION['admin_username'] ?? 'A', 0, 1)) ?></div>
        <span class="uname d-none d-md-inline"><?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></span>
        <i class="bi bi-chevron-down" style="font-size:10px; color:#999;"></i>
      </div>
      <ul class="dropdown-menu dropdown-menu-end shadow border-0">
        <li><h6 class="dropdown-header"><?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></h6></li>
        <li><a class="dropdown-item" href="<?= SITE_URL ?>/dashboard/system-settings.php"><i class="bi bi-gear me-2"></i>Settings</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-danger" href="<?= SITE_URL ?>/dashboard/logout.php"><i class="bi bi-power me-2"></i>Logout</a></li>
      </ul>
    </div>
  </div>
</header>
