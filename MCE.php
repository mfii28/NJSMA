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
    <section class="the-mayor-details-area mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="the-mayor-img-wrap text-center">
                        <img src="<?= SITE_URL ?>/dashboard/assets/img/profileImg/mce.jpg" class="img-fluid rounded shadow" alt="MCE Image">
                        <div class="mt-3">
                            <h3 class="fw-bold">Hon. <?= htmlspecialchars($firstName . ' ' . $lastName) ?></h3>
                            <p class="text-muted">Municipal Chief Executive</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="the-mayor-profile">
                        <h2 class="mb-4">Message from the M.C.E</h2>
                        <div class="profile-content">
                            <p>Hon. <?= htmlspecialchars($firstName . ' ' . $lastName) ?> is dedicated to the progress and development of the New Juaben South Municipality. Under his leadership, the Assembly focuses on transparency, community engagement, and sustainable infrastructure.</p>
                            
                            <h4 class="mt-4">Education & Background</h4>
                            <p>Hon. Isaac Appaw-Gyasi attended Achimota School and York University, Canada. He has a strong background in administrative studies and leadership, which he brings to his role as the Municipal Chief Executive.</p>
                            
                            <h4 class="mt-4">Vision for NJSMA</h4>
                            <p>To transform the New Juaben South Municipality into a hub of economic activity, clean environment, and improved quality of life for all residents.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>