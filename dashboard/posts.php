<?php
require_once __DIR__ . '/../src/init.php';
if (empty($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }

$db = \Core\Database::getInstance();
$postModel = new \Models\Post();
$msg = '';
$msgType = 'success';
$action = $_GET['action'] ?? 'list';
$editId = (int)($_GET['id'] ?? 0);
$editPost = null;

// ---- Handle POST actions ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formAction = $_POST['form_action'] ?? '';

    if ($formAction === 'save') {
        $title    = trim($_POST['PostTitle'] ?? '');
        $content  = $_POST['PostContent'] ?? '';
        $catId    = (int)($_POST['CategoryId'] ?? 0);
        $isActive = isset($_POST['Is_Active']) ? 1 : 0;
        $postId   = (int)($_POST['post_id'] ?? 0);

        // Handle image upload
        $imageName = $_POST['existing_image'] ?? '';
        if (!empty($_FILES['PostImage']['name'])) {
            $ext = pathinfo($_FILES['PostImage']['name'], PATHINFO_EXTENSION);
            $imageName = 'post_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['PostImage']['tmp_name'], ROOT_PATH . '/dashboard/postimages/' . $imageName);
        }

        if ($postId) {
            $db->execute("UPDATE tblposts SET PostTitle=:t, PostDetails=:c, CategoryId=:cat, Is_Active=:a, PostImage=:img WHERE id=:id",
                ['t' => $title, 'c' => $content, 'cat' => $catId, 'a' => $isActive, 'img' => $imageName, 'id' => $postId]);
            $msg = 'Post updated successfully!';
        } else {
            $db->execute("INSERT INTO tblposts (PostTitle, PostDetails, CategoryId, Is_Active, PostImage, PostingDate) VALUES (:t,:c,:cat,:a,:img,NOW())",
                ['t' => $title, 'c' => $content, 'cat' => $catId, 'a' => $isActive, 'img' => $imageName]);
            $msg = 'New post published!';
        }
        header('Location: posts.php?msg=' . urlencode($msg));
        exit;
    }

    if ($formAction === 'delete') {
        $delId = (int)($_POST['delete_id'] ?? 0);
        $db->execute("DELETE FROM tblposts WHERE id=:id", ['id' => $delId]);
        header('Location: posts.php?msg=' . urlencode('Post deleted.'));
        exit;
    }

    if ($formAction === 'toggle') {
        $tid = (int)($_POST['toggle_id'] ?? 0);
        $db->execute("UPDATE tblposts SET Is_Active = NOT Is_Active WHERE id=:id", ['id' => $tid]);
        header('Location: posts.php?msg=' . urlencode('Post status toggled.'));
        exit;
    }
}

// ---- Load for edit ----
if ($action === 'edit' && $editId) {
    $editPost = $db->fetch("SELECT * FROM tblposts WHERE id=:id", ['id' => $editId]);
}

if (isset($_GET['msg'])) { $msg = $_GET['msg']; }

$categories = $db->fetchAll("SELECT * FROM tblcategory ORDER BY CategoryName");
$posts = $db->fetchAll("SELECT p.*, c.CategoryName FROM tblposts p LEFT JOIN tblcategory c ON c.id = p.CategoryId ORDER BY p.PostingDate DESC");
$currentPage = 'News & Posts';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Posts – NJSMA Admin</title>
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

      <?php if ($msg): ?>
      <div class="adm-alert adm-alert-success mb-4"><i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars($msg) ?></div>
      <?php endif; ?>

      <?php if ($action === 'new' || $action === 'edit'): ?>
      <!-- ============ FORM ============ -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h5 class="fw-bold mb-1"><?= $editPost ? 'Edit Post' : 'New News Post' ?></h5>
          <p class="text-muted mb-0" style="font-size:14px;"><?= $editPost ? 'Update the details of this post' : 'Compose and publish a new article' ?></p>
        </div>
        <a href="posts.php" class="adm-btn adm-btn-outline"><i class="bi bi-arrow-left"></i> Back to Posts</a>
      </div>

      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="form_action" value="save">
        <input type="hidden" name="post_id" value="<?= $editPost['id'] ?? '' ?>">
        <input type="hidden" name="existing_image" value="<?= htmlspecialchars($editPost['PostImage'] ?? '') ?>">
        <div class="row g-3">
          <div class="col-lg-8">
            <div class="adm-card">
              <div class="adm-card-header"><h6><i class="bi bi-pencil-fill"></i> Post Content</h6></div>
              <div class="adm-card-body p-4">
                <div class="mb-3">
                  <label class="adm-form-label">Post Title *</label>
                  <input type="text" name="PostTitle" class="adm-form-control" required value="<?= htmlspecialchars($editPost['PostTitle'] ?? '') ?>" placeholder="Enter a compelling headline...">
                </div>
                <div class="mb-0">
                  <label class="adm-form-label">Content Body *</label>
                  <textarea name="PostContent" id="postContent" rows="16" class="adm-form-control" required placeholder="Write your article content here..."><?= htmlspecialchars($editPost['PostDetails'] ?? '') ?></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 d-flex flex-column gap-3">
            <!-- Publish Box -->
            <div class="adm-card">
              <div class="adm-card-header"><h6><i class="bi bi-send-fill text-success"></i> Publish</h6></div>
              <div class="adm-card-body p-4">
                <div class="mb-3">
                  <label class="adm-form-label">Status</label>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="Is_Active" id="statusSwitch" <?= (!isset($editPost) || $editPost['Is_Active']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="statusSwitch">Published</label>
                  </div>
                </div>
                <button type="submit" class="adm-btn adm-btn-primary w-100"><i class="bi bi-save"></i> <?= $editPost ? 'Update Post' : 'Publish Post' ?></button>
              </div>
            </div>
            <!-- Category -->
            <div class="adm-card">
              <div class="adm-card-header"><h6><i class="bi bi-tag-fill text-warning"></i> Category</h6></div>
              <div class="adm-card-body p-4">
                <select name="CategoryId" class="adm-form-control">
                  <option value="">— Select Category —</option>
                  <?php foreach ($categories as $cat): ?>
                  <option value="<?= $cat['id'] ?>" <?= ($editPost['CategoryId'] ?? '') == $cat['id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['CategoryName']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <!-- Featured Image -->
            <div class="adm-card">
              <div class="adm-card-header"><h6><i class="bi bi-image-fill text-info"></i> Featured Image</h6></div>
              <div class="adm-card-body p-4">
                <div id="imagePreviewContainer">
                  <?php if (!empty($editPost['PostImage'])): ?>
                  <img src="<?= SITE_URL ?>/dashboard/postimages/<?= $editPost['PostImage'] ?>" id="imagePreview" class="img-fluid rounded mb-3" style="max-height:140px;object-fit:cover;width:100%;">
                  <?php else: ?>
                  <img src="#" id="imagePreview" class="img-fluid rounded mb-3 d-none" style="max-height:140px;object-fit:cover;width:100%;">
                  <?php endif; ?>
                </div>
                <input type="file" name="PostImage" id="postImageInput" class="adm-form-control" accept="image/*">
                <small class="text-muted mt-1 d-block">Recommended: 800×500px, JPG or PNG</small>
              </div>
            </div>
          </div>
        </div>
      </form>

      <script>
        document.getElementById('postImageInput').onchange = evt => {
          const [file] = evt.target.files;
          if (file) {
            const preview = document.getElementById('imagePreview');
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');
          }
        }
      </script>

      <?php else: ?>
      <!-- ============ LIST ============ -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h5 class="fw-bold mb-1">News Posts</h5>
          <p class="text-muted mb-0" style="font-size:14px;"><?= count($posts) ?> total posts in the system</p>
        </div>
        <a href="posts.php?action=new" class="adm-btn adm-btn-primary shadow-sm"><i class="bi bi-plus-lg"></i> New Post</a>
      </div>

      <div class="adm-card">
        <div class="adm-card-body">
          <table class="adm-table w-100">
            <thead>
              <tr><th>#</th><th>Image</th><th>Title</th><th>Category</th><th>Date</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
              <?php foreach ($posts as $i => $p): ?>
              <tr>
                <td class="text-muted"><?= $i + 1 ?></td>
                <td>
                  <?php if(!empty($p['PostImage'])): ?>
                  <img src="<?= SITE_URL ?>/dashboard/postimages/<?= $p['PostImage'] ?>" class="rounded" style="width:40px;height:40px;object-fit:cover;">
                  <?php else: ?>
                  <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width:40px;height:40px;"><i class="bi bi-image"></i></div>
                  <?php endif; ?>
                </td>
                <td style="max-width:280px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-weight:500;"><?= htmlspecialchars($p['PostTitle']) ?></td>
                <td><span class="adm-badge adm-badge-info"><?= htmlspecialchars($p['CategoryName'] ?? 'Uncategorized') ?></span></td>
                <td class="text-muted" style="font-size:13px;"><?= date('M d, Y', strtotime($p['PostingDate'])) ?></td>
                <td>
                  <form method="POST" style="display:inline;">
                    <input type="hidden" name="form_action" value="toggle">
                    <input type="hidden" name="toggle_id" value="<?= $p['id'] ?>">
                    <button type="submit" class="adm-btn adm-btn-sm <?= $p['Is_Active'] ? 'adm-badge-success' : 'adm-badge-warning' ?>" style="border:none;cursor:pointer;">
                      <?= $p['Is_Active'] ? 'Active' : 'Draft' ?>
                    </button>
                  </form>
                </td>
                <td>
                  <a href="posts.php?action=edit&id=<?= $p['id'] ?>" class="adm-btn adm-btn-outline adm-btn-sm me-1">Edit</a>
                  <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this post?');">
                    <input type="hidden" name="form_action" value="delete">
                    <input type="hidden" name="delete_id" value="<?= $p['id'] ?>">
                    <button type="submit" class="adm-btn adm-btn-danger adm-btn-sm">Delete</button>
                  </form>
                </td>
              </tr>
              <?php endforeach; ?>
              <?php if (empty($posts)): ?>
              <tr><td colspan="7" class="text-center py-5 text-muted">No posts yet. <a href="posts.php?action=new">Create one!</a></td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
      <?php endif; ?>

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
