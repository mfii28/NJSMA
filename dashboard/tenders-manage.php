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
    
    // Handle Delete
    if ($formAction === 'delete') {
        $deleteId = (int)($_POST['delete_id'] ?? 0);
        if ($deleteId) {
            $db->execute("DELETE FROM tbltenders WHERE id=:id", ['id' => $deleteId]);
            header('Location: tenders-manage.php?msg=Tender deleted!'); exit;
        }
    }
    
    if ($formAction === 'save') {
        $title = trim($_POST['Title'] ?? '');
        $desc = $_POST['Description'] ?? '';
        $ref = trim($_POST['ReferenceNo'] ?? '');
        $cost = trim($_POST['Cost'] ?? '');
        $location = trim($_POST['Location'] ?? '');
        $status = $_POST['Status'] ?? 'Open';
        $progress = (int)($_POST['Progress'] ?? 0);
        $deadline = $_POST['Deadline'] ?? null;
        $id = (int)($_POST['id'] ?? 0);

        // Document upload
        $doc = $_POST['existing_doc'] ?? '';
        if (!empty($_FILES['TenderDoc']['name'])) {
            $ext = pathinfo($_FILES['TenderDoc']['name'], PATHINFO_EXTENSION);
            $doc = 'tender_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['TenderDoc']['tmp_name'], ROOT_PATH . '/docs/' . $doc);
        }

        if ($id) {
            $db->execute("UPDATE tbltenders SET Title=:t, Description=:d, ReferenceNo=:r, Cost=:c, Location=:l, Status=:s, Progress=:p, Deadline=:dl, DocumentPath=:doc WHERE id=:id",
                ['t'=>$title, 'd'=>$desc, 'r'=>$ref, 'c'=>$cost, 'l'=>$location, 's'=>$status, 'p'=>$progress, 'dl'=>$deadline, 'doc'=>$doc, 'id'=>$id]);
            $msg = 'Tender updated!';
        } else {
            $db->execute("INSERT INTO tbltenders (Title, Description, ReferenceNo, Cost, Location, Status, Progress, Deadline, DocumentPath) VALUES (:t,:d,:r,:c,:l,:s,:p,:dl,:doc)",
                ['t'=>$title, 'd'=>$desc, 'r'=>$ref, 'c'=>$cost, 'l'=>$location, 's'=>$status, 'p'=>$progress, 'dl'=>$deadline, 'doc'=>$doc]);
            $msg = 'Tender added!';
        }
        header('Location: tenders-manage.php?msg=' . urlencode($msg)); exit;
    }
}

if ($action === 'edit' && $editId) {
    $item = $db->fetch("SELECT * FROM tbltenders WHERE id=:id", ['id' => $editId]);
}

$tenders = $db->fetchAll("SELECT * FROM tbltenders ORDER BY CreatedAt DESC");
$currentPage = 'Procurement & Tenders';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><title>Manage Tenders – NJSMA Admin</title>
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
        <div><h5 class="fw-bold"><?= $item ? 'Edit Tender' : 'New Tender' ?></h5></div>
        <a href="tenders-manage.php" class="adm-btn adm-btn-outline">Back</a>
      </div>
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="form_action" value="save">
        <input type="hidden" name="id" value="<?= $item['id'] ?? '' ?>">
        <input type="hidden" name="existing_doc" value="<?= $item['DocumentPath'] ?? '' ?>">
        <div class="row g-3">
          <div class="col-lg-8">
            <div class="adm-card p-4 mb-3">
              <h6 class="fw-bold mb-3 text-primary">Tender Information</h6>
              <div class="mb-3"><label class="adm-form-label">Title *</label><input type="text" name="Title" class="adm-form-control" required value="<?= htmlspecialchars($item['Title'] ?? '') ?>"></div>
              <div class="mb-3"><label class="adm-form-label">Description</label><textarea name="Description" rows="4" class="adm-form-control"><?= htmlspecialchars($item['Description'] ?? '') ?></textarea></div>
              <div class="row">
                <div class="col-md-6 mb-3"><label class="adm-form-label">Reference Number</label><input type="text" name="ReferenceNo" class="adm-form-control" value="<?= htmlspecialchars($item['ReferenceNo'] ?? '') ?>"></div>
                <div class="col-md-6 mb-3"><label class="adm-form-label">Location</label><input type="text" name="Location" class="adm-form-control" value="<?= htmlspecialchars($item['Location'] ?? '') ?>"></div>
              </div>
              <div class="mb-0"><label class="adm-form-label">Budget/Contract Value</label><input type="text" name="Cost" class="adm-form-control" value="<?= htmlspecialchars($item['Cost'] ?? '') ?>" placeholder="e.g. GHS 500,000"></div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="adm-card p-4 mb-3">
              <h6 class="fw-bold mb-3 text-primary">Status & Timeline</h6>
              <div class="mb-3"><label class="adm-form-label">Status</label><select name="Status" class="adm-form-control">
                <?php foreach(['Open','Closed','Awarded','In Progress','Completed'] as $s): ?>
                <option value="<?= $s ?>" <?= ($item['Status'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
                <?php endforeach; ?>
              </select></div>
              <div class="mb-3"><label class="adm-form-label">Progress (%)</label><input type="number" name="Progress" class="adm-form-control" min="0" max="100" value="<?= $item['Progress'] ?? 0 ?>"></div>
              <div class="mb-3"><label class="adm-form-label">Deadline</label><input type="date" name="Deadline" class="adm-form-control" value="<?= $item['Deadline'] ?? '' ?>"></div>
              <div class="mb-0">
                <label class="adm-form-label">Tender Document</label>
                <?php if(!empty($item['DocumentPath'])): ?>
                  <p class="small text-muted mb-2"><i class="bi bi-file-earmark"></i> <?= htmlspecialchars($item['DocumentPath']) ?></p>
                <?php endif; ?>
                <input type="file" name="TenderDoc" class="adm-form-control" accept=".pdf,.doc,.docx">
              </div>
            </div>
            <button type="submit" class="adm-btn adm-btn-primary w-100">Save Tender</button>
          </div>
        </div>
      </form>
      <?php else: ?>
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="fw-bold">Tenders & Procurement</h5></div>
        <a href="tenders-manage.php?action=new" class="adm-btn adm-btn-primary">+ Add Tender</a>
      </div>
      <div class="adm-card p-0">
        <table class="adm-table w-100">
          <thead><tr><th>#</th><th>Title</th><th>Reference</th><th>Status</th><th>Deadline</th><th>Actions</th></tr></thead>
          <tbody>
            <?php foreach ($tenders as $i => $row): ?>
            <tr>
              <td><?= $i+1 ?></td>
              <td class="fw-bold"><?= htmlspecialchars($row['Title']) ?></td>
              <td><?= htmlspecialchars($row['ReferenceNo']) ?></td>
              <td><span class="adm-badge adm-badge-<?= strtolower(str_replace(' ', '-', $row['Status'])) ?>"><?= $row['Status'] ?></span></td>
              <td><?= $row['Deadline'] ? date('M d, Y', strtotime($row['Deadline'])) : 'N/A' ?></td>
              <td>
                <a href="tenders-manage.php?action=edit&id=<?= $row['id'] ?>" class="adm-btn adm-btn-sm adm-btn-outline">Edit</a>
                <form method="POST" class="d-inline" onsubmit="return confirm('Delete this tender?');">
                  <input type="hidden" name="form_action" value="delete">
                  <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                  <button type="submit" class="adm-btn adm-btn-sm adm-btn-danger">Delete</button>
                </form>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($tenders)): ?>
            <tr><td colspan="6" class="text-center py-4 text-muted">No tenders found. Add your first tender.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
