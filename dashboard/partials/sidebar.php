<?php
require_once __DIR__ . '/../../src/init.php';
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: ' . SITE_URL . '/dashboard/login.php');
    exit;
}
$currentPage = $currentPage ?? 'Dashboard';
$currentFile = basename($_SERVER['PHP_SELF']);

function navLink($href, $icon, $label, $file, $currentFile) {
    $base = basename(parse_url($href, PHP_URL_PATH));
    $active = ($base === $currentFile) ? ' active' : '';
    return "<li><a href=\"{$href}\" class=\"{$active}\"><i class=\"bi {$icon}\"></i> {$label}</a></li>";
}
?>
<!-- Sidebar -->
<aside class="adm-sidebar" id="admSidebar">
  <div class="adm-sidebar-brand">
    <div>
      <div class="brand-name">NJSMA<span>.</span></div>
      <div class="brand-sub">Admin Portal</div>
    </div>
  </div>
  <ul class="adm-nav">
    <?= navLink(SITE_URL.'/dashboard/index.php', 'bi-grid-1x2-fill', 'Dashboard', $currentFile, $currentFile) ?>

    <li class="adm-nav-section">Content</li>
    <?= navLink(SITE_URL.'/dashboard/posts.php', 'bi-newspaper', 'News & Posts', $currentFile, $currentFile) ?>
    <?= navLink(SITE_URL.'/dashboard/events-manage.php', 'bi-calendar-event', 'Events', $currentFile, $currentFile) ?>
    <?= navLink(SITE_URL.'/dashboard/gallery-manage.php', 'bi-images', 'Gallery', $currentFile, $currentFile) ?>
    <?= navLink(SITE_URL.'/dashboard/pages-manage.php', 'bi-file-earmark-richtext', 'Static Pages', $currentFile, $currentFile) ?>

    <li class="adm-nav-section">Municipal</li>
    <?= navLink(SITE_URL.'/dashboard/mce-manage.php', 'bi-award', 'MCE Office', $currentFile, $currentFile) ?>
    <?= navLink(SITE_URL.'/dashboard/departments.php', 'bi-building', 'Departments', $currentFile, $currentFile) ?>
    <?= navLink(SITE_URL.'/dashboard/members-manage.php', 'bi-people-fill', 'Assembly Members', $currentFile, $currentFile) ?>
    <?= navLink(SITE_URL.'/dashboard/management-manage.php', 'bi-person-badge', 'Management Team', $currentFile, $currentFile) ?>
    <?= navLink(SITE_URL.'/dashboard/projects-manage.php', 'bi-briefcase', 'Projects', $currentFile, $currentFile) ?>
    <?= navLink(SITE_URL.'/dashboard/tenders-manage.php', 'bi-box-seam', 'Procurement & Tenders', $currentFile, $currentFile) ?>

    <li class="adm-nav-section">Documents & Finance</li>
    <?= navLink(SITE_URL.'/dashboard/budgets-manage.php', 'bi-cash-coin', 'Budgets & Finance', $currentFile, $currentFile) ?>
    <?= navLink(SITE_URL.'/dashboard/repository-manage.php', 'bi-folder2-open', 'Documents Center', $currentFile, $currentFile) ?>

    <li class="adm-nav-section">Citizen Portal</li>
    <?= navLink(SITE_URL.'/dashboard/messages-manage.php', 'bi-chat-left-dots', 'Feedback & Messages', $currentFile, $currentFile) ?>
    <?= navLink(SITE_URL.'/dashboard/faqs-manage.php', 'bi-question-circle', 'FAQs', $currentFile, $currentFile) ?>
    <?= navLink(SITE_URL.'/dashboard/careers-manage.php', 'bi-person-plus', 'Careers', $currentFile, $currentFile) ?>
    <?= navLink(SITE_URL.'/dashboard/zonal-councils.php', 'bi-geo-alt', 'Zonal Councils', $currentFile, $currentFile) ?>

    <li class="adm-nav-section">System</li>
    <?= navLink(SITE_URL.'/dashboard/system-settings.php', 'bi-gear-fill', 'Site Settings', $currentFile, $currentFile) ?>

    <li><div class="nav-divider"></div></li>
    <li><a href="<?= SITE_URL ?>/" target="_blank"><i class="bi bi-box-arrow-up-right"></i> View Public Site</a></li>
    <li><a href="<?= SITE_URL ?>/dashboard/logout.php" style="color: #ff6b6b;"><i class="bi bi-power"></i> Logout</a></li>
  </ul>
</aside>
<div class="adm-overlay" id="admOverlay" onclick="toggleSidebar()"></div>
