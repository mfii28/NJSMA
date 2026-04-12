<?php
require_once __DIR__ . '/../src/init.php';
if (empty($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }

$settingModel = new \Models\Setting();
$successMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keys = ['site_name','contact_email','contact_phone','contact_address','digital_address',
             'facebook_link','twitter_link','linkedin_link','about_vision','about_mission',
             'about_mandate','about_intro',
             'history_content','history_established_year',
             'assembly_governance','assembly_functions',
             'charter_intro','charter_commitments','charter_hotline','charter_email',
             'location_content',
             'fee_fixing_year','fee_fixing_summary',
             'admin_username','admin_password_hash'];
    foreach ($keys as $key) {
        if (!isset($_POST[$key])) continue;
        if ($key === 'admin_password_hash' && empty($_POST[$key])) continue; // skip if blank
        $value = ($key === 'admin_password_hash') ? password_hash($_POST[$key], PASSWORD_DEFAULT) : trim($_POST[$key]);
        $settingModel->update($key, $value);
    }
    $GLOBAL_SETTINGS = $settingModel->getAllAsKeyValue();
    $successMsg = 'Settings saved successfully!';
}

$s = $GLOBAL_SETTINGS ?? [];
$currentPage = 'Site Settings';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Settings — NJSMA Admin</title>
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

      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h5 class="fw-bold mb-1">Site Settings</h5>
          <p class="text-muted mb-0" style="font-size:14px;">Control global information shown across the website</p>
        </div>
        <button form="settingsForm" type="submit" class="adm-btn adm-btn-primary shadow-sm"><i class="bi bi-save"></i> Save Changes</button>
      </div>

      <?php if ($successMsg): ?>
      <div class="adm-alert adm-alert-success"><i class="bi bi-check-circle-fill"></i> <?= $successMsg ?></div>
      <?php endif; ?>

      <form method="POST" action="" id="settingsForm">
        <div class="row g-3">

          <!-- Contact & Location -->
          <div class="col-lg-6">
            <div class="adm-card h-100">
              <div class="adm-card-header"><h6><i class="bi bi-geo-alt-fill text-primary"></i> Contact & Location</h6></div>
              <div class="adm-card-body p-4">
                <div class="mb-3">
                  <label class="adm-form-label">Site Name</label>
                  <input type="text" name="site_name" class="adm-form-control" value="<?= htmlspecialchars($s['site_name'] ?? '') ?>">
                </div>
                <div class="mb-3">
                  <label class="adm-form-label">Digital Address (e.g. EN-010-4770)</label>
                  <input type="text" name="digital_address" class="adm-form-control" value="<?= htmlspecialchars($s['digital_address'] ?? '') ?>">
                </div>
                <div class="mb-3">
                  <label class="adm-form-label">Physical Address</label>
                  <input type="text" name="contact_address" class="adm-form-control" value="<?= htmlspecialchars($s['contact_address'] ?? '') ?>">
                </div>
                <div class="mb-3">
                  <label class="adm-form-label">Phone Number</label>
                  <input type="text" name="contact_phone" class="adm-form-control" value="<?= htmlspecialchars($s['contact_phone'] ?? '') ?>">
                </div>
                <div class="mb-0">
                  <label class="adm-form-label">Email Address</label>
                  <input type="email" name="contact_email" class="adm-form-control" value="<?= htmlspecialchars($s['contact_email'] ?? '') ?>">
                </div>
              </div>
            </div>
          </div>

          <!-- Social Media -->
          <div class="col-lg-6">
            <div class="adm-card mb-3">
              <div class="adm-card-header"><h6><i class="bi bi-share-fill text-info"></i> Social Media Links</h6></div>
              <div class="adm-card-body p-4">
                <div class="mb-3">
                  <label class="adm-form-label"><i class="bi bi-facebook me-1 text-primary"></i> Facebook URL</label>
                  <input type="url" name="facebook_link" class="adm-form-control" value="<?= htmlspecialchars($s['facebook_link'] ?? '') ?>">
                </div>
                <div class="mb-3">
                  <label class="adm-form-label"><i class="bi bi-twitter me-1" style="color:#1da1f2;"></i> Twitter/X URL</label>
                  <input type="url" name="twitter_link" class="adm-form-control" value="<?= htmlspecialchars($s['twitter_link'] ?? '') ?>">
                </div>
                <div class="mb-0">
                  <label class="adm-form-label"><i class="bi bi-linkedin me-1" style="color:#0077b5;"></i> LinkedIn URL</label>
                  <input type="url" name="linkedin_link" class="adm-form-control" value="<?= htmlspecialchars($s['linkedin_link'] ?? '') ?>">
                </div>
              </div>
            </div>
            <!-- Admin Credentials -->
            <div class="adm-card">
              <div class="adm-card-header"><h6><i class="bi bi-shield-lock-fill text-danger"></i> Admin Credentials</h6></div>
              <div class="adm-card-body p-4">
                <div class="mb-3">
                  <label class="adm-form-label">Admin Username</label>
                  <input type="text" name="admin_username" class="adm-form-control" value="<?= htmlspecialchars($s['admin_username'] ?? 'admin') ?>">
                </div>
                <div class="mb-0">
                  <label class="adm-form-label">New Password (leave blank to keep current)</label>
                  <input type="password" name="admin_password_hash" class="adm-form-control" placeholder="Enter new password...">
                </div>
              </div>
            </div>
          </div>

          <!-- Mission & Vision -->
          <div class="col-12">
            <div class="adm-card">
              <div class="adm-card-header"><h6><i class="bi bi-info-circle-fill text-success"></i> About Content — Mission & Vision</h6></div>
              <div class="adm-card-body p-4">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="adm-form-label">Our Vision Statement</label>
                    <textarea name="about_vision" rows="4" class="adm-form-control"><?= htmlspecialchars($s['about_vision'] ?? '') ?></textarea>
                  </div>
                  <div class="col-md-6">
                    <label class="adm-form-label">Our Mission Statement</label>
                    <textarea name="about_mission" rows="4" class="adm-form-control"><?= htmlspecialchars($s['about_mission'] ?? '') ?></textarea>
                  </div>
                  <div class="col-12">
                    <label class="adm-form-label">About Page Introduction</label>
                    <textarea name="about_intro" rows="3" class="adm-form-control" placeholder="Brief introduction text for the About page..."><?= htmlspecialchars($s['about_intro'] ?? '') ?></textarea>
                  </div>
                  <div class="col-12">
                    <label class="adm-form-label">Our Mandate (full text)</label>
                    <textarea name="about_mandate" rows="6" class="adm-form-control" placeholder="Detailed mandate text..."><?= htmlspecialchars($s['about_mandate'] ?? '') ?></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- History Content -->
          <div class="col-12">
            <div class="adm-card">
              <div class="adm-card-header"><h6><i class="bi bi-clock-history text-warning"></i> History Page Content</h6></div>
              <div class="adm-card-body p-4">
                <div class="row g-3">
                  <div class="col-md-4">
                    <label class="adm-form-label">Assembly Established Year</label>
                    <input type="text" name="history_established_year" class="adm-form-control" placeholder="e.g. 2008" value="<?= htmlspecialchars($s['history_established_year'] ?? '') ?>">
                  </div>
                  <div class="col-12">
                    <label class="adm-form-label">Full History Content</label>
                    <textarea name="history_content" rows="10" class="adm-form-control" placeholder="Write the full history of NJSMA here..."><?= htmlspecialchars($s['history_content'] ?? '') ?></textarea>
                    <small class="text-muted">Use HTML tags for formatting if needed (p, h3, ul, li, etc.)</small>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Assembly Info Content -->
          <div class="col-12">
            <div class="adm-card">
              <div class="adm-card-header"><h6><i class="bi bi-building text-primary"></i> Assembly Info Page Content</h6></div>
              <div class="adm-card-body p-4">
                <div class="row g-3">
                  <div class="col-12">
                    <label class="adm-form-label">Governance Structure Description</label>
                    <textarea name="assembly_governance" rows="6" class="adm-form-control" placeholder="Description of the governance structure..."><?= htmlspecialchars($s['assembly_governance'] ?? '') ?></textarea>
                  </div>
                  <div class="col-12">
                    <label class="adm-form-label">Core Functions (bullet points, one per line)</label>
                    <textarea name="assembly_functions" rows="6" class="adm-form-control" placeholder="Enter each function on a new line..."><?= htmlspecialchars($s['assembly_functions'] ?? '') ?></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Service Charter Content -->
          <div class="col-12">
            <div class="adm-card">
              <div class="adm-card-header"><h6><i class="bi bi-clipboard-check text-success"></i> Service Charter Page Content</h6></div>
              <div class="adm-card-body p-4">
                <div class="row g-3">
                  <div class="col-12">
                    <label class="adm-form-label">Charter Introduction</label>
                    <textarea name="charter_intro" rows="4" class="adm-form-control" placeholder="Introduction text for the service charter..."><?= htmlspecialchars($s['charter_intro'] ?? '') ?></textarea>
                  </div>
                  <div class="col-12">
                    <label class="adm-form-label">Our Commitments (bullet points, one per line)</label>
                    <textarea name="charter_commitments" rows="5" class="adm-form-control" placeholder="Enter each commitment on a new line..."><?= htmlspecialchars($s['charter_commitments'] ?? '') ?></textarea>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <label class="adm-form-label">Complaints Hotline</label>
                      <input type="text" name="charter_hotline" class="adm-form-control" value="<?= htmlspecialchars($s['charter_hotline'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                      <label class="adm-form-label">Complaints Email</label>
                      <input type="email" name="charter_email" class="adm-form-control" value="<?= htmlspecialchars($s['charter_email'] ?? '') ?>">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Location & Land Size Content -->
          <div class="col-12">
            <div class="adm-card">
              <div class="adm-card-header"><h6><i class="bi bi-geo-alt-fill text-primary"></i> Location & Land Size Page Content</h6></div>
              <div class="adm-card-body p-4">
                <div class="mb-3">
                  <label class="adm-form-label">Location Page Content</label>
                  <textarea name="location_content" rows="8" class="adm-form-control" placeholder="Full content for Location & Land Size page..."><?= htmlspecialchars($s['location_content'] ?? '') ?></textarea>
                  <small class="text-muted">Leave blank to use default content about boundaries, land size, climate, and population.</small>
                </div>
              </div>
            </div>
          </div>

          <!-- Fee Fixing / Rate Management -->
          <div class="col-12">
            <div class="adm-card">
              <div class="adm-card-header"><h6><i class="bi bi-cash-coin text-warning"></i> Fee Fixing / Rate Management</h6></div>
              <div class="adm-card-body p-4">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="adm-form-label">Current Fee Fixing Year</label>
                    <input type="text" name="fee_fixing_year" class="adm-form-control" placeholder="e.g. 2024" value="<?= htmlspecialchars($s['fee_fixing_year'] ?? '') ?>">
                  </div>
                  <div class="col-12">
                    <label class="adm-form-label">Fee Fixing Summary / Notes</label>
                    <textarea name="fee_fixing_summary" rows="4" class="adm-form-control" placeholder="Summary of current fee structure or notes..."><?= htmlspecialchars($s['fee_fixing_summary'] ?? '') ?></textarea>
                  </div>
                </div>
                <div class="mt-3 alert alert-info">
                  <i class="bi bi-info-circle me-2"></i> Upload detailed Fee Fixing documents (PDF) in the <a href="repository-manage.php">Documents Center</a> under "Fee Fixing" category.
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- Save Bottom -->
        <div class="text-end mt-4">
          <button type="submit" class="adm-btn adm-btn-primary shadow px-5"><i class="bi bi-save me-1"></i> Save All Settings</button>
        </div>
      </form>
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
