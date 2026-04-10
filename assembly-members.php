<?php
require_once __DIR__ . '/src/init.php';

use Models\AssemblyMember;
$memberModel = new AssemblyMember();
$members = $memberModel->getAll();

$pageTitle = "Assembly Members | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';
?>

<main id="main">
    <section class="breadcrumbs d-flex align-items-center" style="background-image: url('dashboard/assets/img/heroImg/slider-3.jpg'); height: 200px; background-size: cover;">
        <div class="container text-center">
            <h2 class="text-white">Assembly Members</h2>
        </div>
    </section>

    <section id="members" class="members section-bg mt-5">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2>Our Assembly Members</h2>
          <p>The elected and appointed members representing various electoral areas within the municipality.</p>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Electoral Area / Role</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($members as $m): ?>
                        <tr>
                            <td><h6 class="mb-0"><?= htmlspecialchars($m['FullName']) ?></h6></td>
                            <td><?= htmlspecialchars($m['ElectoralArea']) ?></td>
                            <td><span class="badge bg-primary"><?= htmlspecialchars($m['Position']) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
      </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>
