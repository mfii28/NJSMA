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
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="<?= SITE_URL ?>" class="text-white">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= SITE_URL ?>/deptInfo.php" class="text-white">Departments</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page"><?= htmlspecialchars($dept['DeptName']) ?></li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="department-details pb-5">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-4">
                    <div class="dept-head-box shadow-sm">
                        <img src="<?= SITE_URL ?>/dashboard/assets/img/profileImg/<?= $dept['HeadImage'] ?? 'default.jpg' ?>" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;" alt="">
                        <h4><?= htmlspecialchars($dept['HeadName'] ?? 'Head of Department') ?></h4>
                        <p class="text-muted">Head, <?= htmlspecialchars($dept['DeptName']) ?></p>
                    </div>
                    
                    <div class="sidebar-nav mt-4 shadow-sm">
                        <h4>Explore Departments</h4>
                        <ul class="list-unstyled mb-0">
                            <?php 
                            $allDepts = $deptModel->getAll();
                            foreach($allDepts as $d): if($d['id'] == $dept['id']) continue; 
                            ?>
                                <li><a href="?id=<?= $d['id'] ?>"><i class="bi bi-chevron-right me-2 text-primary"></i> <?= htmlspecialchars($d['DeptName']) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="content-card shadow-sm">
                        <h3>Mandate & Overview</h3>
                        <div class="description-text mb-5" style="line-height: 1.8; color: #555;">
                            <?= nl2br(htmlspecialchars($dept['Description'])) ?>
                        </div>
                        
                        <div class="info-banner">
                            <h4 class="mb-3"><i class="bi bi-check2-circle me-2"></i> Role & Responsibilities</h4>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2 d-flex align-items-start"><i class="bi bi-dot me-2 fs-4"></i> Policy formulation and implementation within the municipality.</li>
                                <li class="mb-2 d-flex align-items-start"><i class="bi bi-dot me-2 fs-4"></i> Coordination of specialized municipal services for residents.</li>
                                <li class="mb-0 d-flex align-items-start"><i class="bi bi-dot me-2 fs-4"></i> Monitoring and reporting on localized developmental initiatives.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>
