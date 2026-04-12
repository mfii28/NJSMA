<?php
require_once __DIR__ . '/src/init.php';

use Models\Department;
$deptModel = new Department();

$deptId = $_GET['id'] ?? null;
if (!$deptId) {
    header("Location: deptInfo.php");
    exit;
}

$dept = $deptModel->getById($deptId);
if (!$dept) {
    echo "Department not found.";
    exit;
}

$pageTitle = $dept['DeptName'] . " | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';
?>

<main id="main">
    <section class="page-header text-center">
        <div class="container">
            <h1><?= htmlspecialchars($dept['DeptName']) ?></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent mt-2">
                    <li class="breadcrumb-item"><a href="<?= SITE_URL ?>/" class="text-white"><i class="bi bi-house-door me-1"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= SITE_URL ?>/deptInfo" class="text-white">Departments</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page"><?= htmlspecialchars($dept['DeptName']) ?></li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="department-details pb-5">
        <div class="container" data-aos="fade-up">
            <div class="row position-relative">
                <div class="col-lg-4">
                    <div class="sticky-sidebar">
                        <div class="dept-head-box shadow-sm">
                            <img src="/njsma/dashboard/assets/img/profileImg/<?= $dept['HeadImage'] ?? 'default.jpg' ?>" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1);" alt="">
                            <h4 class="fw-bold"><?= htmlspecialchars($dept['HeadName'] ?? 'Head of Department') ?></h4>
                            <p class="text-muted small text-uppercase letter-spacing-1">Head, <?= htmlspecialchars($dept['DeptName']) ?></p>
                        </div>
                        
                        <div class="sidebar-nav mt-4 shadow-sm">
                            <h4>Explore Departments</h4>
                            <ul class="list-unstyled mb-0">
                                <?php 
                                $allDepts = $deptModel->getAll();
                                foreach($allDepts as $d): if($d['id'] == $dept['id']) continue; 
                                ?>
                                    <li><a href="?id=<?= $d['id'] ?>"><i class="bi bi-chevron-right me-2 text-primary small"></i> <?= htmlspecialchars($d['DeptName']) ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="content-card shadow-sm">
                        <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-3">Department Overview</span>
                        <h3 class="fw-bold mb-4">Mandate & Description</h3>
                        <div class="description-text mb-5 text-muted" style="line-height: 1.8; font-size: 16px;">
                            <?= nl2br(htmlspecialchars($dept['Description'] ?? 'Description not available yet for this department.')) ?>
                        </div>
                        
                        <?php if (!empty($dept['Objectives'])): ?>
                        <div class="info-banner bg-light text-dark mb-5 border-start border-4 border-primary">
                            <h4 class="mb-3 fw-bold text-primary"><i class="bi bi-bullseye me-2"></i> Our Objectives</h4>
                            <div class="text-muted" style="line-height: 1.7;">
                                <?= nl2br($dept['Objectives']) // Can contain safe HTML or just newlines ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($dept['Functions'])): ?>
                        <h4 class="fw-bold mb-4 border-bottom pb-2">Roles & Functions</h4>
                        <div class="functions-list text-muted mb-5" style="line-height: 1.8;">
                            <?= $dept['Functions'] ?>
                        </div>
                        <?php else: ?>
                        <div class="info-banner mb-5">
                            <h4 class="mb-3"><i class="bi bi-check2-circle me-2"></i> Role & Responsibilities</h4>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2 d-flex align-items-start"><i class="bi bi-dot me-2 fs-4"></i> Policy formulation and implementation within the municipality.</li>
                                <li class="mb-2 d-flex align-items-start"><i class="bi bi-dot me-2 fs-4"></i> Coordination of specialized municipal services for residents.</li>
                                <li class="mb-0 d-flex align-items-start"><i class="bi bi-dot me-2 fs-4"></i> Monitoring and reporting on localized developmental initiatives.</li>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($dept['AdminDetails'])): ?>
                        <div class="content-card shadow-none border bg-light mt-4">
                            <h5 class="fw-bold mb-3"><i class="bi bi-info-circle me-2 text-primary"></i> Administrative Details</h5>
                            <p class="mb-0 text-muted small" style="line-height: 1.6;">
                                <?= nl2br(htmlspecialchars($dept['AdminDetails'])) ?>
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>
