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
    <section class="breadcrumbs d-flex align-items-center" style="background-image: url('dashboard/assets/img/heroImg/slider-1.jpg'); height: 200px; background-size: cover;">
        <div class="container text-center">
            <h2 class="text-white"><?= htmlspecialchars($dept['DeptName']) ?></h2>
        </div>
    </section>

    <section class="department-details mt-5">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-4">
                    <div class="headOfDept text-center p-4 shadow-sm bg-white rounded">
                        <img src="<?= SITE_URL ?>/dashboard/assets/img/profileImg/<?= $dept['HeadImage'] ?? 'default.jpg' ?>" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;" alt="">
                        <h4><?= htmlspecialchars($dept['HeadName'] ?? 'Head of Department') ?></h4>
                        <p class="text-muted">Head, <?= htmlspecialchars($dept['DeptName']) ?></p>
                    </div>
                    
                    <div class="sidebar-box mt-4 p-4 bg-light">
                        <h4>Other Departments</h4>
                        <ul class="list-unstyled">
                            <?php 
                            $allDepts = $deptModel->getAll();
                            foreach($allDepts as $d): if($d['id'] == $dept['id']) continue; 
                            ?>
                                <li class="mb-2"><a href="?id=<?= $d['id'] ?>"><?= htmlspecialchars($d['DeptName']) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="content p-4">
                        <h3>About the Department</h3>
                        <div class="mt-4">
                            <?= nl2br(htmlspecialchars($dept['Description'])) ?>
                        </div>
                        
                        <div class="mt-5 p-4 bg-primary text-white rounded">
                            <h4>Key Responsibilities</h4>
                            <ul>
                                <li>Policy formation and implementation within the municipality.</li>
                                <li>Coordination of specialized municipal services.</li>
                                <li>Monitoring and reporting on localized development projects.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>
