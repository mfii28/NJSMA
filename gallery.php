<?php
require_once __DIR__ . '/src/init.php';

// Simple direct query for now or create a model if needed
$db = Core\Database::getInstance();
$galleries = $db->fetchAll("SELECT * FROM tblgallery ORDER BY CreatedAt DESC");

$pageTitle = "Media Gallery | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';
?>

<main id="main">
    <section class="page-header text-center">
        <div class="container">
            <h1>Media Gallery</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="<?= SITE_URL ?>" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Gallery</li>
                </ol>
            </nav>
        </div>
    </section>

    <section id="gallery" class="gallery pb-5">
      <div class="container" data-aos="fade-up">
        <div class="row">
          <?php if (empty($galleries)): ?>
             <div class="col-12">
                <div class="content-card text-center py-5 shadow-sm">
                   <i class="bi bi-images fs-1 text-muted mb-3"></i>
                   <h4>Our Gallery is Expanding</h4>
                   <p class="text-muted">New photos and videos from municipal projects will be uploaded soon.</p>
                </div>
             </div>
          <?php else: ?>
            <?php foreach ($galleries as $g): ?>
              <div class="col-lg-4 col-md-6 mb-4" data-aos="zoom-in">
                <div class="gallery-item-card">
                  <div class="gallery-img">
                    <img src="/njsma/dashboard/assets/img/gallery/<?= $g['ThumbImage'] ?? 'default-gallery.jpg' ?>" class="img-fluid" alt="<?= htmlspecialchars($g['Title']) ?>">
                  </div>
                  <div class="gallery-overlay">
                    <h4><?= htmlspecialchars($g['Title']) ?></h4>
                    <p><?= htmlspecialchars($g['Description']) ?></p>
                    <a href="<?= SITE_URL ?>/gallery-details.php?id=<?= $g['id'] ?>" class="gallery-btn">
                      <i class="bi bi-plus-lg"></i>
                    </a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>
