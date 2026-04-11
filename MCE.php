<?php
require_once __DIR__ . '/src/init.php';

use Models\MceModel;
$mceModel = new MceModel();
$mce = $mceModel->getMceInfo();

$pageTitle = "The MCE | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';

// If DB fails, we can show a placeholder or handle it
$firstName = $mce['first_name'] ?? 'Isaac';
$lastName = $mce['last_name'] ?? 'Appaw-Gyasi';
?>

<main id="main">
    <section class="page-header text-center">
        <div class="container">
            <h1>The MCE's Office</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="<?= SITE_URL ?>" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">The MCE</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="the-mayor-details pb-5">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-4">
                    <div class="dept-head-box shadow-sm text-center">
                        <img src="<?= SITE_URL ?>/dashboard/assets/img/profileImg/mce.jpg" class="img-fluid rounded mb-3" alt="MCE Image">
                        <div class="mt-3">
                            <h3 class="fw-bold text-primary">Hon. <?= htmlspecialchars($firstName . ' ' . $lastName) ?></h3>
                            <p class="text-muted text-uppercase small letter-spacing-1">Municipal Chief Executive</p>
                        </div>
                        <div class="social-links mt-4 d-flex justify-content-center gap-3">
                            <a href="#" class="btn btn-sm btn-outline-primary rounded-circle"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="btn btn-sm btn-outline-primary rounded-circle"><i class="bi bi-twitter-x"></i></a>
                            <a href="#" class="btn btn-sm btn-outline-primary rounded-circle"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>

                    <div class="info-banner small mt-4 shadow-sm">
                        <h6>Contact the Office</h6>
                        <ul class="list-unstyled mb-0 mt-3 small">
                            <li class="mb-2"><i class="bi bi-envelope me-2"></i> info@njsma.gov.gh</li>
                            <li class="mb-0"><i class="bi bi-telephone me-2"></i> +233 34 229 3669</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="content-card shadow-sm">
                        <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill mb-3">MCE's Message</span>
                        <h2 class="fw-bold mb-4">Building a Better Municipal for All</h2>
                        <div class="profile-content text-muted" style="line-height: 1.8;">
                            <p>Hon. <?= htmlspecialchars($firstName . ' ' . $lastName) ?> is dedicated to the progress and development of the New Juaben South Municipality. Under his leadership, the Assembly focuses on transparency, community engagement, and sustainable infrastructure.</p>
                            
                            <h4 class="mt-5 text-dark fw-bold">Education & Background</h4>
                            <p>Hon. Isaac Appaw-Gyasi attended Achimota School and York University, Canada. He has a strong background in administrative studies and leadership, which he brings to his role as the Municipal Chief Executive.</p>
                            
                            <h4 class="mt-5 text-dark fw-bold">Vision for NJSMA</h4>
                            <div class="bg-light p-4 rounded-3 border-start border-4 border-primary">
                                <p class="mb-0 italic">"To transform the New Juaben South Municipality into a hub of economic activity, clean environment, and improved quality of life for all residents."</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>