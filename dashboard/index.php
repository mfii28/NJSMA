<?php
require_once __DIR__ . '/../src/init.php';
if (empty($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }

$db = \Core\Database::getInstance();
$postCount    = $db->fetch("SELECT COUNT(*) as c FROM tblposts WHERE Is_Active = 1")['c'] ?? 0;
$deptCount    = $db->fetch("SELECT COUNT(*) as c FROM tbldepartments")['c'] ?? 0;
$tenderCount  = $db->fetch("SELECT COUNT(*) as c FROM tbltenders WHERE Status = 'Open'")['c'] ?? 0;
$galleryCount = $db->fetch("SELECT COUNT(*) as c FROM tblgallery")['c'] ?? 0;
$recentPosts  = $db->fetchAll("SELECT id, PostTitle, PostingDate, Is_Active FROM tblposts ORDER BY PostingDate DESC LIMIT 6");
$recentTenders = $db->fetchAll("SELECT id, Title, Status, Deadline FROM tbltenders ORDER BY id DESC LIMIT 5");

$currentPage = 'Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard — NJSMA Admin</title>
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

      <!-- Welcome Bar -->
      <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
          <h5 class="fw-800 mb-1">Good <?= (date('H') < 12) ? 'Morning' : ((date('H') < 18) ? 'Afternoon' : 'Evening') ?>, <?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?> 👋</h5>
          <p class="text-muted mb-0" style="font-size:14px;"><?= date('l, F j, Y') ?> — Here's your NJSMA overview</p>
        </div>
        <a href="posts.php?action=new" class="adm-btn adm-btn-primary shadow-sm"><i class="bi bi-plus-lg"></i> New Post</a>
      </div>

      <!-- Stat Cards -->
      <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
          <div class="stat-card" style="--card-accent: #056839;">
            <div class="stat-icon" style="background:#e8f5e9;"><i class="bi bi-newspaper" style="color:#056839;"></i></div>
            <div class="stat-value"><?= $postCount ?></div>
            <div class="stat-label">News Posts Published</div>
            <a href="posts.php" class="stat-link">Manage Posts <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
        <div class="col-sm-6 col-xl-3">
          <div class="stat-card" style="--card-accent: #1565c0;">
            <div class="stat-icon" style="background:#e3f2fd;"><i class="bi bi-building" style="color:#1565c0;"></i></div>
            <div class="stat-value"><?= $deptCount ?></div>
            <div class="stat-label">Departments</div>
            <a href="departments.php" class="stat-link">Manage <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
        <div class="col-sm-6 col-xl-3">
          <div class="stat-card" style="--card-accent: #f57f17;">
            <div class="stat-icon" style="background:#fff8e1;"><i class="bi bi-box-seam" style="color:#f57f17;"></i></div>
            <div class="stat-value"><?= $tenderCount ?></div>
            <div class="stat-label">Open Tenders</div>
            <a href="tenders-manage.php" class="stat-link">View Tenders <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
        <div class="col-sm-6 col-xl-3">
          <div class="stat-card" style="--card-accent: #7b1fa2;">
            <div class="stat-icon" style="background:#f3e5f5;"><i class="bi bi-images" style="color:#7b1fa2;"></i></div>
            <div class="stat-value"><?= $galleryCount ?></div>
            <div class="stat-label">Gallery Items</div>
            <a href="gallery-manage.php" class="stat-link">Manage <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <!-- Tables + Quick Actions -->
      <div class="row g-3">
        <!-- Recent Posts -->
        <div class="col-lg-8">
          <div class="adm-card">
            <div class="adm-card-header">
              <h6><i class="bi bi-newspaper text-success"></i> Recent News Posts</h6>
              <a href="posts.php" class="adm-btn adm-btn-outline adm-btn-sm">View All</a>
            </div>
            <div class="adm-card-body">
              <table class="adm-table w-100">
                <thead>
                  <tr><th>Title</th><th>Date</th><th>Status</th><th>Action</th></tr>
                </thead>
                <tbody>
                  <?php foreach ($recentPosts as $p): ?>
                  <tr>
                    <td style="max-width:280px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= htmlspecialchars($p['PostTitle']) ?></td>
                    <td class="text-muted"><?= date('M d, Y', strtotime($p['PostingDate'])) ?></td>
                    <td><span class="adm-badge <?= $p['Is_Active'] ? 'adm-badge-success' : 'adm-badge-warning' ?>"><?= $p['Is_Active'] ? 'Active' : 'Draft' ?></span></td>
                    <td><a href="posts.php?action=edit&id=<?= $p['id'] ?>" class="adm-btn adm-btn-outline adm-btn-sm">Edit</a></td>
                  </tr>
                  <?php endforeach; ?>
                  <?php if (empty($recentPosts)): ?>
                  <tr><td colspan="4" class="text-center py-5 text-muted">No posts yet. <a href="posts.php?action=new">Create one!</a></td></tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4 d-flex flex-column gap-3">

          <!-- Quick Actions -->
          <div class="adm-card">
            <div class="adm-card-header"><h6><i class="bi bi-lightning-charge text-warning"></i> Quick Actions</h6></div>
            <div class="adm-card-body p-3 d-flex flex-column gap-2">
              <a href="posts.php?action=new" class="adm-btn adm-btn-outline w-100 justify-content-start"><i class="bi bi-plus-circle"></i>New News Post</a>
              <a href="tenders-manage.php?action=new" class="adm-btn adm-btn-outline w-100 justify-content-start"><i class="bi bi-plus-circle"></i>Add Tender</a>
              <a href="gallery-manage.php?action=new" class="adm-btn adm-btn-outline w-100 justify-content-start"><i class="bi bi-cloud-upload"></i>Upload Gallery Image</a>
              <a href="system-settings.php" class="adm-btn adm-btn-outline w-100 justify-content-start"><i class="bi bi-gear"></i>Edit Site Settings</a>
            </div>
          </div>

          <!-- Recent Tenders -->
          <div class="adm-card">
            <div class="adm-card-header">
              <h6><i class="bi bi-box-seam text-warning"></i> Tenders</h6>
              <a href="tenders-manage.php" class="adm-btn adm-btn-outline adm-btn-sm">View All</a>
            </div>
            <div class="adm-card-body">
              <?php foreach (array_slice($recentTenders, 0, 4) as $t): ?>
              <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom" style="font-size:13px;">
                <span style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= htmlspecialchars($t['Title']) ?></span>
                <span class="adm-badge <?= $t['Status'] === 'Open' ? 'adm-badge-success' : 'adm-badge-danger' ?>"><?= $t['Status'] ?></span>
              </div>
              <?php endforeach; ?>
              <?php if (empty($recentTenders)): ?>
              <p class="text-center text-muted py-4 mb-0 small">No tenders yet.</p>
              <?php endif; ?>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleSidebar() {
      document.getElementById('admSidebar').classList.toggle('open');
      document.getElementById('admOverlay').classList.toggle('show');
    }
  </script>
</body>
</html>
