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
        $date  = $_POST['EventDate'] ?? null;
        $venue = $_POST['Venue'] ?? '';
        $org   = $_POST['Organizer'] ?? '';
        $reg   = $_POST['RegistrationLink'] ?? '';
        $id    = (int)($_POST['id'] ?? 0);

        // Image
        $img = $_POST['existing_image'] ?? '';
        if (!empty($_FILES['EventImage']['name'])) {
            $ext = pathinfo($_FILES['EventImage']['name'], PATHINFO_EXTENSION);
            $img = 'event_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['EventImage']['tmp_name'], ROOT_PATH . '/dashboard/assets/img/events/' . $img);
        }

        if ($id) {
            $db->execute("UPDATE tblevents SET Title=:t, Description=:d, EventDate=:ed, Venue=:v, Organizer=:o, Image=:img, RegistrationLink=:rl WHERE id=:id",
                ['t'=>$title, 'd'=>$desc, 'ed'=>$date, 'v'=>$venue, 'o'=>$org, 'img'=>$img, 'rl'=>$reg, 'id'=>$id]);
            $msg = 'Event updated!';
        } else {
            $db->execute("INSERT INTO tblevents (Title, Description, EventDate, Venue, Organizer, Image, RegistrationLink) VALUES (:t,:d,:ed,:v,:o,:img,:rl)",
                ['t'=>$title, 'd'=>$desc, 'ed'=>$date, 'v'=>$venue, 'o'=>$org, 'img'=>$img, 'rl'=>$reg]);
            $msg = 'Event added!';
        }
        header('Location: events-manage.php?msg=' . urlencode($msg)); exit;
    }

    if ($formAction === 'delete') {
        $db->execute("DELETE FROM tblevents WHERE id=:id", ['id' => (int)$_POST['delete_id']]);
        header('Location: events-manage.php?msg=' . urlencode('Event deleted.')); exit;
    }
}

if ($action === 'edit' && $editId) {
    $item = $db->fetch("SELECT * FROM tblevents WHERE id=:id", ['id' => $editId]);
}

if (isset($_GET['msg'])) $msg = $_GET['msg'];
$events = $db->fetchAll("SELECT * FROM tblevents ORDER BY EventDate DESC");
$currentPage = 'Events';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><title>Manage Events – NJSMA Admin</title>
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
        <div><h5 class="fw-bold"><?= $item ? 'Edit Event' : 'New Event' ?></h5></div>
        <a href="events-manage.php" class="adm-btn adm-btn-outline">Back</a>
      </div>
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="form_action" value="save">
        <input type="hidden" name="id" value="<?= $item['id'] ?? '' ?>">
        <input type="hidden" name="existing_image" value="<?= $item['Image'] ?? '' ?>">
        <div class="row g-3">
          <div class="col-lg-8">
            <div class="adm-card p-4">
              <div class="mb-3"><label class="adm-form-label">Event Title *</label><input type="text" name="Title" class="adm-form-control" required value="<?= $item['Title'] ?? '' ?>"></div>
              <div class="mb-3"><label class="adm-form-label">Description</label><textarea name="Description" rows="10" class="adm-form-control"><?= $item['Description'] ?? '' ?></textarea></div>
              <div class="mb-0"><label class="adm-form-label">Registration/RSVP Link (Optional)</label><input type="url" name="RegistrationLink" class="adm-form-control" value="<?= $item['RegistrationLink'] ?? '' ?>" placeholder="https://..."></div>
            </div>
          </div>
          <div class="col-lg-4 d-flex flex-column gap-3">
            <div class="adm-card p-4">
              <div class="mb-3"><label class="adm-form-label">Date & Time</label><input type="datetime-local" name="EventDate" class="adm-form-control" required value="<?= isset($item['EventDate']) ? date('Y-m-d\TH:i', strtotime($item['EventDate'])) : '' ?>"></div>
              <div class="mb-3"><label class="adm-form-label">Venue</label><input type="text" name="Venue" class="adm-form-control" value="<?= $item['Venue'] ?? '' ?>"></div>
              <div class="mb-3"><label class="adm-form-label">Organizer</label><input type="text" name="Organizer" class="adm-form-control" value="<?= $item['Organizer'] ?? 'Municipal Assembly' ?>"></div>
              <button type="submit" class="adm-btn adm-btn-primary w-100">Save Event</button>
            </div>
            <div class="adm-card p-4">
              <label class="adm-form-label">Event Poster/Image</label>
              <?php if(!empty($item['Image'])): ?><img src="assets/img/events/<?= $item['Image'] ?>" class="img-fluid rounded mb-2"><?php endif; ?>
              <input type="file" name="EventImage" class="adm-form-control">
            </div>
          </div>
        </div>
      </form>
      <?php else: ?>
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="fw-bold">Events Calendar</h5></div>
        <a href="events-manage.php?action=new" class="adm-btn adm-btn-primary">+ Add New Event</a>
      </div>
      <div class="adm-card p-0">
        <table class="adm-table w-100">
          <thead><tr><th>#</th><th>Event</th><th>Date & Time</th><th>Venue</th><th>Actions</th></tr></thead>
          <tbody>
            <?php foreach ($events as $i => $row): ?>
            <tr>
              <td><?= $i+1 ?></td>
              <td class="fw-bold"><?= htmlspecialchars($row['Title']) ?></td>
              <td><?= date('M d, Y | H:i', strtotime($row['EventDate'])) ?></td>
              <td><?= htmlspecialchars($row['Venue']) ?></td>
              <td>
                <a href="events-manage.php?action=edit&id=<?= $row['id'] ?>" class="adm-btn adm-btn-sm adm-btn-outline">Edit</a>
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
