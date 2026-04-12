<?php
require_once __DIR__ . '/src/init.php';

use Models\Career;
$careerModel = new Career();
$vacancies = $careerModel->getAllActive();

$pageTitle = "Careers & Vacancies | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';
?>

<main id="main">
    <section class="page-header text-center">
        <div class="container">
            <h1>Careers & Vacancies</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="<?= SITE_URL ?>" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Careers</li>
                </ol>
            </nav>
        </div>
    </section>

    <section id="careers" class="careers py-5">
        <div class="container" data-aos="fade-up">
            <div class="row g-4">
                <div class="col-lg-8 mx-auto">
                    <div class="mb-5 text-center">
                        <h2>Join Our Professional Team</h2>
                        <p class="text-muted">The New Juaben South Municipal Assembly offers various career opportunities for professionals across different departments. Explore our current openings below.</p>
                    </div>

                    <?php foreach ($vacancies as $job): ?>
                    <div class="content-card mb-4 p-4 shadow-sm border-start border-4 border-primary">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h4 class="mb-1 text-primary fw-bold"><?= htmlspecialchars($job['JobTitle']) ?></h4>
                                <span class="badge bg-light text-dark border me-2"><?= htmlspecialchars($job['DeptName']) ?></span>
                                <span class="badge bg-light text-dark border"><?= htmlspecialchars($job['JobType']) ?></span>
                            </div>
                            <div class="text-end">
                                <small class="text-danger fw-bold d-block">Deadline: <?= date('M d, Y', strtotime($job['Deadline'])) ?></small>
                            </div>
                        </div>
                        <div class="mb-4 text-muted small" style="line-height: 1.6;">
                            <?= nl2br(htmlspecialchars($job['Description'])) ?>
                        </div>
                        <div class="mt-3">
                            <a href="/njsma/contact?subject=Application for <?= urlencode($job['JobTitle']) ?>" class="btn btn-primary">Apply Now</a>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <?php if (empty($vacancies)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-briefcase text-muted" style="font-size: 4rem;"></i>
                        <h4 class="mt-3">No Current Vacancies</h4>
                        <p class="text-muted">There are no open positions at this time. Please check back later or subscribe to our newsletter.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>
