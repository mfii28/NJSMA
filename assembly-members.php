<?php
require_once __DIR__ . '/src/init.php';

use Models\AssemblyMember;
$memberModel = new AssemblyMember();
$members = $memberModel->getAll();

$pageTitle = "Assembly Members | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';
?>

<main id="main">
    <section class="page-header text-center">
        <div class="container">
            <h1>Assembly Members</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="<?= SITE_URL ?>" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Assembly Members</li>
                </ol>
            </nav>
        </div>
    </section>

    <section id="members" class="members py-5">
      <div class="container" data-aos="fade-up">
        <div class="row">
          <?php foreach ($members as $m): ?>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up">
              <div class="profile-card">
                <div class="profile-img">
                  <img src="<?= SITE_URL ?>/dashboard/assets/img/profileImg/<?= $m['Image'] ?? 'default.jpg' ?>" alt="<?= htmlspecialchars($m['FullName']) ?>">
                </div>
                <div class="profile-info">
                  <h4><?= htmlspecialchars($m['FullName']) ?></h4>
                  <p class="text-primary fw-bold"><?= htmlspecialchars($m['ElectoralArea']) ?></p>
                  <span class="badge bg-light text-dark border"><?= htmlspecialchars($m['Position']) ?></span>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>
