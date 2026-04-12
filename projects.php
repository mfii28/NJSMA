<?php
require_once __DIR__ . '/src/init.php';

use Models\Project;
$projectModel = new Project();
$projects = $projectModel->getAll();

$pageTitle = "Projects Register | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';
?>

<main id="main">
    <section class="page-header text-center">
        <div class="container">
            <h1>Municipal Projects</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="<?= SITE_URL ?>" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Projects Register</li>
                </ol>
            </nav>
        </div>
    </section>

    <section id="projects" class="projects py-5">
        <div class="container" data-aos="fade-up">
            <div class="row g-4">
                <?php foreach ($projects as $proj): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="blog-post-card h-100 shadow-sm">
                        <div class="blog-img">
                            <img src="/njsma/dashboard/assets/img/projects/<?= $proj['ProjectImage'] ?: 'placeholder.jpg' ?>" alt="<?= htmlspecialchars($proj['Title']) ?>">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge <?= $proj['Status'] === 'Completed' ? 'bg-success' : ($proj['Status'] === 'Ongoing' ? 'bg-primary' : 'bg-warning') ?>">
                                    <?= $proj['Status'] ?>
                                </span>
                            </div>
                        </div>
                        <div class="blog-content">
                            <h4 class="blog-title mb-2">
                                <a href="javascript:void(0);"><?= htmlspecialchars($proj['Title']) ?></a>
                            </h4>
                            <div class="mb-3">
                                <small class="text-muted"><i class="bi bi-geo-alt-fill me-1"></i> <?= htmlspecialchars($proj['Location']) ?></small>
                            </div>
                            <div class="progress mb-3" style="height: 10px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?= $proj['Progress'] ?>%;" aria-valuenow="<?= $proj['Progress'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="small text-muted"><?= $proj['Progress'] ?>% Complete</span>
                                <span class="small fw-bold"><?= $proj['Cost'] ?: 'Budget Confidential' ?></span>
                            </div>
                            <p class="text-muted small mb-0"><?= mb_strimwidth(strip_tags($proj['Description']), 0, 120, "...") ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

                <?php if (empty($projects)): ?>
                <div class="col-12 text-center py-5">
                    <i class="bi bi-folder-x display-1 text-muted"></i>
                    <p class="mt-3">No developmental projects found in the register.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>
