<?php
require_once __DIR__ . '/src/init.php';

use Models\Management;
$mgmtModel = new Management();
$team = $mgmtModel->getAll();

$pageTitle = "Our Management | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';
?>

<main id="main">
    <section class="page-header text-center">
        <div class="container">
            <h1>Our Management Team</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="<?= SITE_URL ?>" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Management</li>
                </ol>
            </nav>
        </div>
    </section>

    <section id="management" class="management py-5">
      <div class="container" data-aos="fade-up">
        <div class="row">
          <?php foreach ($team as $member): ?>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up">
              <div class="profile-card">
                <div class="profile-img">
                  <img src="/njsma/dashboard/assets/img/management/<?= $member['Image'] ?? 'default.jpg' ?>" alt="<?= htmlspecialchars($member['FullName']) ?>">
                </div>
                <div class="profile-info">
                  <h4><?= htmlspecialchars($member['FullName']) ?></h4>
                  <p><?= htmlspecialchars($member['Position']) ?></p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>
