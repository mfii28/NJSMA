<?php
require_once __DIR__ . '/../src/init.php';
if (empty($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }

$db = \Core\Database::getInstance();
$msg = '';
$action = $_GET['action'] ?? 'list';
$editId = (int)($_GET['id'] ?? 0);
$item = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formAction = $_POST['form_action'] ?? '';

    if ($formAction === 'save') {
        $title = trim($_POST['Title'] ?? '');
        $desc  = $_POST['Description'] ?? '';
        $loc   = $_POST['Location'] ?? '';
        $cost  = $_POST['Cost'] ?? '';
        $status = $_POST['Status'] ?? 'Planned';
        $progress = (int)($_POST['Progress'] ?? 0);
        $sDate = $_POST['StartDate'] ?? null;
        $cDate = $_POST['CompletionDate'] ?? null;
        $contractor = $_POST['Contractor'] ?? '';
        $funding = $_POST['FundingSource'] ?? '';
        $id = (int)($_POST['id'] ?? 0);

        // Image
        $img = $_POST['existing_image'] ?? '';
        if (!empty($_FILES['ProjectImage']['name'])) {
            $ext = pathinfo($_FILES['ProjectImage']['name'], PATHINFO_EXTENSION);
            $img = 'proj_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['ProjectImage']['tmp_name'], ROOT_PATH . '/dashboard/assets/img/projects/' . $img);
        }

        if ($id) {
            $db->execute("UPDATE tblprojects SET Title=:t, Description=:d, Location=:l, Cost=:c, Status=:s, Progress=:p, StartDate=:sd, CompletionDate=:cd, ProjectImage=:img, Contractor=:con, FundingSource=:fs WHERE id=:id",
                ['t'=>$title, 'd'=>$desc, 'l'=>$loc, 'c'=>$cost, 's'=>$status, 'p'=>$progress, 'sd'=>$sDate, 'cd'=>$cDate, 'img'=>$img, 'con'=>$contractor, 'fs'=>$funding, 'id'=>$id]);
            $msg = 'Project updated!';
        } else {
            $db->execute("INSERT INTO tblprojects (Title, Description, Location, Cost, Status, Progress, StartDate, CompletionDate, ProjectImage, Contractor, FundingSource) VALUES (:t,:d,:l,:c,:s,:p,:sd,:cd,:img,:con,:fs)",
                ['t'=>$title, 'd'=>$desc, 'l'=>$loc, 'c'=>$cost, 's'=>$status, 'p'=>$progress, 'sd'=>$sDate, 'cd'=>$cDate, 'img'=>$img, 'con'=>$contractor, 'fs'=>$funding]);
            $msg = 'Project added!';
        }
        header('Location: projects-manage.php?msg=' . urlencode($msg)); exit;
    }

    if ($formAction === 'delete') {
        $db->execute("DELETE FROM tblprojects WHERE id=:id", ['id' => (int)$_POST['delete_id']]);
        header('Location: projects-manage.php?msg=' . urlencode('Project deleted.')); exit;
    }
}

if ($action === 'edit' && $editId) {
    $item = $db->fetch("SELECT * FROM tblprojects WHERE id=:id", ['id' => $editId]);
}

if (isset($_GET['msg'])) $msg = $_GET['msg'];
$projects = $db->fetchAll("SELECT * FROM tblprojects ORDER BY id DESC");
$currentPage = 'Projects';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><title>Manage Projects – NJSMA Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
  <?php include __DIR__ . '/partials/sidebar.php'; ?>
  <div class="adm-main">
    <?php include __DIR__ . '/partials/header.php'; ?>
    <div class="adm-content">
      <?php if ($msg): ?><div class="adm-alert adm-alert-success"><i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars($msg) ?></div><?php endif; ?>

      <?php if ($action === 'new' || $action === 'edit'): ?>
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="fw-bold"><?= $item ? 'Edit Project' : 'New Project' ?></h5></div>
        <a href="projects-manage.php" class="adm-btn adm-btn-outline">Back</a>
      </div>
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="form_action" value="save">
        <input type="hidden" name="id" value="<?= $item['id'] ?? '' ?>">
        <input type="hidden" name="existing_image" value="<?= $item['ProjectImage'] ?? '' ?>">
        <div class="row g-3">
          <div class="col-lg-8">
            <div class="adm-card p-4">
              <div class="mb-3"><label class="adm-form-label">Project Title *</label><input type="text" name="Title" class="adm-form-control" required value="<?= $item['Title'] ?? '' ?>"></div>
              <div class="mb-3"><label class="adm-form-label">Description</label><textarea name="Description" rows="6" class="adm-form-control"><?= $item['Description'] ?? '' ?></textarea></div>
              <div class="row mb-3">
                <div class="col-md-6"><label class="adm-form-label">Location</label><input type="text" name="Location" class="adm-form-control" value="<?= $item['Location'] ?? '' ?>"></div>
                <div class="col-md-6"><label class="adm-form-label">Contractor</label><input type="text" name="Contractor" class="adm-form-control" value="<?= $item['Contractor'] ?? '' ?>"></div>
              </div>
              <div class="row">
                <div class="col-md-6"><label class="adm-form-label">Funding Source</label><input type="text" name="FundingSource" class="adm-form-control" value="<?= $item['FundingSource'] ?? '' ?>"></div>
                <div class="col-md-6"><label class="adm-form-label">Estimated Cost</label><input type="text" name="Cost" class="adm-form-control" value="<?= $item['Cost'] ?? '' ?>"></div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 d-flex flex-column gap-3">
            <div class="adm-card p-4">
              <div class="mb-3"><label class="adm-form-label">Status</label><select name="Status" class="adm-form-control">
                <?php foreach(['Planned','Ongoing','Completed','Suspended'] as $s): ?>
                <option value="<?= $s ?>" <?= ($item['Status'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
                <?php endforeach; ?>
              </select></div>
              <div class="mb-3"><label class="adm-form-label">Progress (<?= $item['Progress'] ?? 0 ?>%)</label><input type="range" name="Progress" class="form-range" min="0" max="100" value="<?= $item['Progress'] ?? 0 ?>"></div>
              <div class="mb-3"><label class="adm-form-label">Start Date</label><input type="date" name="StartDate" class="adm-form-control" value="<?= $item['StartDate'] ?? '' ?>"></div>
              <div class="mb-3"><label class="adm-form-label">Completion Date</label><input type="date" name="CompletionDate" class="adm-form-control" value="<?= $item['CompletionDate'] ?? '' ?>"></div>
              <button type="submit" class="adm-btn adm-btn-primary w-100">Save Project</button>
            </div>
            <div class="adm-card p-4">
              <label class="adm-form-label">Project Image</label>
              <?php if(!empty($item['ProjectImage'])): ?><img src="assets/img/projects/<?= $item['ProjectImage'] ?>" class="img-fluid rounded mb-2"><?php endif; ?>
              <input type="file" name="ProjectImage" class="adm-form-control">
            </div>
          </div>
        </div>
      </form>
      <?php else: ?>
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="fw-bold">Projects</h5></div>
        <a href="projects-manage.php?action=new" class="adm-btn adm-btn-primary">+ New Project</a>
      </div>
      <div class="adm-card p-0">
        <table class="adm-table w-100">
          <thead><tr><th>#</th><th>Title</th><th>Location</th><th>Status</th><th>Progress</th><th>Actions</th></tr></thead>
          <tbody>
            <?php foreach ($projects as $i => $row): ?>
            <tr>
              <td><?= $i+1 ?></td>
              <td class="fw-bold"><?= htmlspecialchars($row['Title']) ?></td>
              <td><?= htmlspecialchars($row['Location']) ?></td>
              <td><span class="adm-badge <?= $row['Status'] === 'Completed' ? 'adm-badge-success' : ($row['Status'] === 'Ongoing' ? 'adm-badge-info' : 'adm-badge-warning') ?>"><?= $row['Status'] ?></span></td>
              <td style="width:150px;"><div class="progress" style="height:8px;"><div class="progress-bar" style="width:<?= $row['Progress'] ?>%"></div></div><small><?= $row['Progress'] ?>%</small></td>
              <td>
                <a href="projects-manage.php?action=edit&id=<?= $row['id'] ?>" class="adm-btn adm-btn-sm adm-btn-outline">Edit</a>
                <form method="POST" class="d-inline" onsubmit="return confirm('Delete?');"><input type="hidden" name="form_action" value="delete"><input type="hidden" name="delete_id" value="<?= $row['id'] ?>"><button type="submit" class="adm-btn adm-btn-sm adm-btn-danger">Delete</button></form>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
