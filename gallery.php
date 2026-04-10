<?php
require_once __DIR__ . '/src/init.php';

// Simple direct query for now or create a model if needed
$db = Core\Database::getInstance();
$galleries = $db->fetchAll("SELECT * FROM tblgallery ORDER BY CreatedAt DESC");

$pageTitle = "Media Gallery | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';
?>

<main id="main">
    <section class="breadcrumbs d-flex align-items-center" style="background-image: url('dashboard/assets/img/heroImg/slider-1.jpg'); height: 200px; background-size: cover;">
        <div class="container text-center">
            <h2 class="text-white">Media Gallery</h2>
        </div>
    </section>

    <section id="portfolio" class="portfolio mt-5">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2>Photos & Videos</h2>
          <p>Memorable moments from municipal events and projects.</p>
        </div>

        <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
          <?php if (empty($galleries)): ?>
             <div class="col-12 text-center">
                <p class="text-muted">No gallery items found yet.</p>
             </div>
          <?php else: ?>
            <?php foreach ($galleries as $g): ?>
              <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                <div class="portfolio-wrap shadow-sm">
                  <img src="<?= SITE_URL ?>/dashboard/assets/img/gallery/<?= $g['ThumbImage'] ?? 'default-gallery.jpg' ?>" class="img-fluid" alt="">
                  <div class="portfolio-info">
                    <h4><?= htmlspecialchars($g['Title']) ?></h4>
                    <p><?= htmlspecialchars($g['Description']) ?></p>
                    <div class="portfolio-links">
                      <a href="<?= SITE_URL ?>/gallery-details.php?id=<?= $g['id'] ?>" title="More Details"><i class="bi bi-link"></i></a>
                    </div>
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
