<?php
require_once __DIR__ . '/src/init.php';

use Models\Management;
$mgmtModel = new Management();
$team = $mgmtModel->getAll();

$pageTitle = "Our Management | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';
?>

<main id="main">
    <section class="breadcrumbs d-flex align-items-center" style="background-image: url('dashboard/assets/img/heroImg/slider-2.jpg'); height: 200px; background-size: cover;">
        <div class="container text-center">
            <h2 class="text-white">Our Management Team</h2>
        </div>
    </section>

    <section id="team" class="team section-bg mt-5">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2>Management</h2>
          <p>Meet the core management team of the New Juaben South Municipal Assembly.</p>
        </div>

        <div class="row">
          <?php foreach ($team as $member): ?>
            <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
              <div class="member shadow-sm">
                <div class="member-img">
                  <img src="<?= SITE_URL ?>/dashboard/assets/img/profileImg/<?= $member['Image'] ?? 'default.jpg' ?>" class="img-fluid" alt="">
                </div>
                <div class="member-info p-3 text-center">
                  <h4><?= htmlspecialchars($member['FullName']) ?></h4>
                  <span><?= htmlspecialchars($member['Position']) ?></span>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>
