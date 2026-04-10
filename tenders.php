<?php
require_once __DIR__ . '/src/init.php';

use Models\Tender;
$tenderModel = new Tender();
$tenders = $tenderModel->getActive();

$pageTitle = "Tenders & Procurement | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';
?>

<main id="main">
    <section class="breadcrumbs d-flex align-items-center" style="background-image: url('dashboard/assets/img/heroImg/slider-1.jpg'); height: 200px; background-size: cover;">
        <div class="container text-center">
            <h2 class="text-white">Tenders & Procurement</h2>
        </div>
    </section>

    <section class="tenders mt-5">
        <div class="container">
            <div class="row">
                <?php if (empty($tenders)): ?>
                    <div class="col-12 text-center py-5">
                        <div class="alert alert-info">There are no open tenders at this time. Please check back later.</div>
                    </div>
                <?php else: ?>
                    <?php foreach ($tenders as $tender): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <small class="text-primary fw-bold">REF: <?= htmlspecialchars($tender['ReferenceNo']) ?></small>
                                        <span class="badge bg-success">Open</span>
                                    </div>
                                    <h5 class="card-title"><?= htmlspecialchars($tender['Title']) ?></h5>
                                    <p class="card-text text-muted"><?= htmlspecialchars($tender['Description']) ?></p>
                                    <div class="border-top pt-3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-calendar-event me-2"></i>
                                            <small>Deadline: <strong><?= date('d M Y', strtotime($tender['Deadline'])) ?></strong></small>
                                        </div>
                                        <a href="#" class="btn btn-primary btn-sm">View Details</a>
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
