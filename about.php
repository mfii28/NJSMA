<?php 
require_once __DIR__ . '/src/init.php';

$pageTitle = "About NJSMA | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';
?>

<main id="main">
    <section class="page-header text-center">
        <div class="container">
            <h1>About NJSMA</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="<?= SITE_URL ?>" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">About Us</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="about-content pb-5">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-8">
                    <div class="content-card shadow-sm mb-4">
                        <h3>Our Mandate</h3>
                        <p>The New Juaben South Municipal Assembly (NJSMA) is one of the administrative districts in the Eastern Region of Ghana. Our primary mandate is to facilitate the overall development of the municipality through the formulation and implementation of plans, programs, and projects at the local level.</p>
                        <p>We work towards providing essential social services, improving infrastructure, and promoting economic growth while ensuring the sustainable use of natural resources within our jurisdiction.</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="content-card shadow-sm h-100">
                                <h4 class="text-primary fw-bold"><i class="bi bi-eye me-2"></i> Vision</h4>
                                <p class="small text-muted">To be a world-class municipal assembly providing excellent services to its citizens in a clean and safe environment.</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="content-card shadow-sm h-100">
                                <h4 class="text-primary fw-bold"><i class="bi bi-bullseye me-2"></i> Mission</h4>
                                <p class="small text-muted">Facilitating the improvement of the quality of life of the people in the municipality through equitable resource mobilization and distribution.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sidebar-nav shadow-sm">
                        <h4>Quick Links</h4>
                        <ul class="list-unstyled mb-0">
                            <li><a href="<?= SITE_URL ?>/MCE.php"><i class="bi bi-person me-2"></i> The MCE</a></li>
                            <li><a href="<?= SITE_URL ?>/management.php"><i class="bi bi-people me-2"></i> Management Team</a></li>
                            <li><a href="<?= SITE_URL ?>/assembly-members.php"><i class="bi bi-person-badge me-2"></i> Assembly Members</a></li>
                            <li><a href="<?= SITE_URL ?>/Histroy.php"><i class="bi bi-clock-history me-2"></i> Our History</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>