<?php
require_once __DIR__ . '/src/init.php';

use Models\Tender;
$tenderModel = new Tender();
$tenders = $tenderModel->getActive();

$pageTitle = "Tenders & Procurement | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';
?>

<main id="main">
    <section class="page-header text-center">
        <div class="container">
            <h1>Tenders & Procurement</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="<?= SITE_URL ?>" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Tenders</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="tenders pb-5">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <?php if (empty($tenders)): ?>
                    <div class="col-12">
                        <div class="content-card text-center py-5 shadow-sm">
                            <i class="bi bi-info-circle fs-1 text-primary mb-3"></i>
                            <h4>No Active Tenders</h4>
                            <p class="text-muted">There are no open tenders at this time. Please check back later for new procurement opportunities.</p>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($tenders as $tender): ?>
                        <div class="col-lg-6 mb-4">
                            <div class="content-card shadow-sm h-100 p-4 border-top border-4 border-success">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill small">REF: <?= htmlspecialchars($tender['ReferenceNo']) ?></span>
                                    <span class="badge bg-success rounded-pill px-3 py-2 small">OPEN</span>
                                </div>
                                <h4 class="fw-bold mb-3"><?= htmlspecialchars($tender['Title']) ?></h4>
                                <p class="text-muted mb-4 small" style="line-height: 1.6;"><?= htmlspecialchars($tender['Description']) ?></p>
                                <div class="mt-auto d-flex justify-content-between align-items-center pt-3 border-top">
                                    <div class="text-danger small fw-bold">
                                        <i class="bi bi-clock-history me-1"></i>
                                        Deadline: <?= date('d M Y', strtotime($tender['Deadline'])) ?>
                                    </div>
                                    <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-4">View Details</a>
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
