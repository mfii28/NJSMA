<?php 
require_once __DIR__ . '/src/init.php';

$pageTitle = "The Assembly | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';
?>

<main id="main">
    <section class="page-header text-center">
        <div class="container">
            <h1>The Assembly</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="<?= SITE_URL ?>" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">The Assembly</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="assembly-content pb-5">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-8">
                    <div class="content-card shadow-sm mb-4 border-start border-4 border-primary">
                        <h3>Governance Structure</h3>
                        <?php if (!empty($GLOBAL_SETTINGS['assembly_governance'])): ?>
                            <?= nl2br(htmlspecialchars($GLOBAL_SETTINGS['assembly_governance'])) ?>
                        <?php else: ?>
                            <p>The New Juaben South Municipal Assembly is the highest political and administrative authority in the municipality. It consists of elected and appointed members, the Municipal Chief Executive, and the Member of Parliament.</p>
                            <p>The Assembly is presided over by a Presiding Member elected from among the members of the Assembly.</p>
                        <?php endif; ?>
                    </div>

                    <div class="content-card shadow-sm mb-4">
                        <h4>Core Functions</h4>
                        <?php if (!empty($GLOBAL_SETTINGS['assembly_functions'])): ?>
                            <ul class="list-unstyled mt-3" style="line-height: 2;">
                                <?php foreach (explode("\n", $GLOBAL_SETTINGS['assembly_functions']) as $function): ?>
                                    <?php if (trim($function)): ?>
                                        <li><i class="bi bi-check-circle-fill text-success me-2"></i> <?= htmlspecialchars(trim($function)) ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <ul class="list-unstyled mt-3" style="line-height: 2;">
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i> Responsible for the overall development of the municipality.</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i> Formulation and implementation of development plans and budgets.</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i> Provision of basic infrastructure and social services.</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i> Maintenance of security and public safety.</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i> Promotion and support of productive activity and social development.</li>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sidebar-nav shadow-sm mb-4">
                        <h4>Administrative Wings</h4>
                        <ul class="list-unstyled mb-0">
                            <li><a href="<?= SITE_URL ?>/deptInfo.php"><i class="bi bi-building me-2"></i> Technical Departments</a></li>
                            <li><a href="<?= SITE_URL ?>/management.php"><i class="bi bi-people me-2"></i> Central Administration</a></li>
                            <li><a href="<?= SITE_URL ?>/assembly-members.php"><i class="bi bi-person-badge me-2"></i> Legislative Body</a></li>
                        </ul>
                    </div>

                    <div class="info-banner">
                        <h5 class="fw-bold">Citizen Charter</h5>
                        <p class="small mb-0">Learn about our service standards and commitments to you.</p>
                        <a href="<?= SITE_URL ?>/service-charter.php" class="btn btn-sm btn-light mt-3">View Charter</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>