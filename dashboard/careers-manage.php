<?php
require_once __DIR__ . '/../src/init.php';
if (empty($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }

$db = \Core\Database::getInstance();
$msg = $_GET['msg'] ?? '';
$action = $_GET['action'] ?? 'list';
$editId = (int)($_GET['id'] ?? 0);
$item = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formAction = $_POST['form_action'] ?? '';
    if ($formAction === 'save') {
        $title = trim($_POST['JobTitle'] ?? '');
        $dept  = (int)($_POST['DepartmentId'] ?? 0);
        $type  = $_POST['JobType'] ?? 'Full-time';
        $desc  = $_POST['Description'] ?? '';
        $req   = $_POST['Requirements'] ?? '';
        $dead  = $_POST['Deadline'] ?? null;
        $status = $_POST['Status'] ?? 'Active';
        $id    = (int)($_POST['id'] ?? 0);

        if ($id) {
            $db->execute("UPDATE tblcareers SET JobTitle=:t, DepartmentId=:d, JobType=:jt, Description=:ds, Requirements=:r, Deadline=:dl, Status=:s WHERE id=:id",
                ['t'=>$title, 'd'=>$dept, 'jt'=>$type, 'ds'=>$desc, 'r'=>$req, 'dl'=>$dead, 's'=>$status, 'id'=>$id]);
        } else {
            $db->execute("INSERT INTO tblcareers (JobTitle, DepartmentId, JobType, Description, Requirements, Deadline, Status) VALUES (:t,:d,:jt,:ds,:r,:dl,:s)",
                ['t'=>$title, 'd'=>$dept, 'jt'=>$type, 'ds'=>$desc, 'r'=>$req, 'dl'=>$dead, 's'=>$status]);
        }
        header('Location: careers-manage.php?msg=Job saved!'); exit;
    }
}

if ($action === 'edit' && $editId) $item = $db->fetch("SELECT * FROM tblcareers WHERE id=:id", ['id'=>$editId]);
$jobs = $db->fetchAll("SELECT j.*, d.DeptName FROM tblcareers j LEFT JOIN tbldepartments d ON d.id = j.DepartmentId ORDER BY j.CreatedAt DESC");
$depts = $db->fetchAll("SELECT id, DeptName FROM tbldepartments ORDER BY DeptName");
$currentPage = 'Careers';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><title>Manage Careers – NJSMA Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
  <?php include __DIR__ . '/partials/sidebar.php'; ?>
  <div class="adm-main">
    <?php include __DIR__ . '/partials/header.php'; ?>
    <div class="adm-content">
      <?php if ($msg): ?><div class="adm-alert adm-alert-success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>

      <?php if ($action === 'new' || $action === 'edit'): ?>
      <h5 class="fw-bold mb-4"><?= $item ? 'Edit Vacancy' : 'New Vacancy' ?></h5>
      <form method="POST">
        <input type="hidden" name="form_action" value="save"><input type="hidden" name="id" value="<?= $item['id'] ?? '' ?>">
        <div class="row g-3">
          <div class="col-lg-8"><div class="adm-card p-4">
            <div class="mb-3"><label class="adm-form-label">Job Title *</label><input type="text" name="JobTitle" class="adm-form-control" required value="<?= $item['JobTitle'] ?? '' ?>"></div>
            <div class="mb-3"><label class="adm-form-label">Description</label><textarea name="Description" rows="5" class="adm-form-control"><?= $item['Description'] ?? '' ?></textarea></div>
            <div class="mb-0"><label class="adm-form-label">Requirements (List format)</label><textarea name="Requirements" rows="5" class="adm-form-control"><?= $item['Requirements'] ?? '' ?></textarea></div>
          </div></div>
          <div class="col-lg-4 d-flex flex-column gap-3"><div class="adm-card p-4">
            <div class="mb-3"><label class="adm-form-label">Department</label><select name="DepartmentId" class="adm-form-control"><option value="">Select Dept</option><?php foreach($depts as $d): ?><option value="<?= $d['id'] ?>" <?= ($item['DepartmentId']??'')==$d['id']?'selected':'' ?>><?= $d['DeptName'] ?></option><?php endforeach; ?></select></div>
            <div class="mb-3"><label class="adm-form-label">Job Type</label><select name="JobType" class="adm-form-control"><?php foreach(['Full-time','Part-time','Contract','Internship'] as $t): ?><option value="<?= $t ?>" <?= ($item['JobType']??'')==$t?'selected':'' ?>><?= $t ?></option><?php endforeach; ?></select></div>
            <div class="mb-3"><label class="adm-form-label">Deadline</label><input type="date" name="Deadline" class="adm-form-control" value="<?= $item['Deadline'] ?? '' ?>"></div>
            <div class="mb-3"><label class="adm-form-label">Status</label><select name="Status" class="adm-form-control"><option value="Active" <?=($item['Status']??'')=='Active'?'selected':''?>>Active</option><option value="Expired" <?=($item['Status']??'')=='Expired'?'selected':''?>>Expired</option></select></div>
            <button type="submit" class="adm-btn adm-btn-primary w-100">Save Vacancy</button>
          </div></div>
        </div>
      </form>
      <?php else: ?>
      <div class="d-flex justify-content-between align-items-center mb-4"><h5 class="fw-bold">Job Openings</h5><a href="careers-manage.php?action=new" class="adm-btn adm-btn-primary">+ Add New</a></div>
      <div class="adm-card p-0"><table class="adm-table w-100">
        <thead><tr><th>#</th><th>Job Title</th><th>Dept</th><th>Type</th><th>Deadline</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
          <?php foreach ($jobs as $i => $row): ?>
          <tr><td><?= $i+1 ?></td><td class="fw-bold"><?= htmlspecialchars($row['JobTitle']) ?></td><td><?= $row['DeptName'] ?></td><td><?= $row['JobType'] ?></td><td><?= $row['Deadline'] ?></td><td><span class="adm-badge <?= $row['Status']=='Active'?'adm-badge-success':'adm-badge-danger'?>"><?= $row['Status'] ?></span></td>
          <td><a href="careers-manage.php?action=edit&id=<?= $row['id'] ?>" class="adm-btn adm-btn-sm adm-btn-outline">Edit</a></td></tr>
          <?php endforeach; ?>
        </tbody>
      </table></div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
