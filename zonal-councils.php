<?php
require_once __DIR__ . '/src/init.php';

use Models\ZonalCouncil;
$zonalModel = new ZonalCouncil();
$councils = $zonalModel->getAll();

$pageTitle = "Zonal Councils | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';
?>

<main id="main">
    <section class="page-header text-center">
        <div class="container">
            <h1>Zonal Councils</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="<?= SITE_URL ?>" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Zonal Councils</li>
                </ol>
            </nav>
        </div>
    </section>

    <section id="zonal-councils" class="zonal-councils py-5">
        <div class="container" data-aos="fade-up">
            <div class="row g-4">
                <?php foreach ($councils as $council): ?>
                <div class="col-lg-6">
                    <div class="content-card h-100 p-4 shadow-sm">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="bi bi-geo-fill fs-4"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 fw-bold"><?= htmlspecialchars($council['CouncilName']) ?></h4>
                                <small class="text-muted"><?= htmlspecialchars($council['Location']) ?></small>
                            </div>
                        </div>
                        <div class="mb-4 text-muted small" style="line-height: 1.6;">
                            <?= nl2br(htmlspecialchars($council['Description'])) ?>
                        </div>
                        <div class="border-top pt-3 d-flex justify-content-between">
                            <div class="small"><i class="bi bi-person-fill text-primary me-1"></i> Chairman: <strong><?= htmlspecialchars($council['Chairman']) ?></strong></div>
                            <div class="small"><i class="bi bi-telephone-fill text-primary me-1"></i> <?= htmlspecialchars($council['ContactPhone']) ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

                <?php if (empty($councils)): ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No zonal councils information available.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>
