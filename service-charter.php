<?php
require_once __DIR__ . '/src/init.php';

$pageTitle = "Client Service Charter | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';
?>

<main id="main">
    <section class="page-header text-center">
        <div class="container">
            <h1>Client Service Charter</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="<?= SITE_URL ?>" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Service Charter</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="service-charter pb-5">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-8">
                    <div class="content-card shadow-sm mb-4">
                        <h3>Commitment to Quality</h3>
                        <p class="text-muted">This Client Service Charter is a public statement of our commitment to provide quality service to all our clients. It outlines what we do, our service standards, and how you can help us improve.</p>

                        <h4 class="mt-5 mb-4 fw-bold">Our Service Standards</h4>
                        <div class="table-responsive rounded-3 border">
                            <table class="table table-hover mb-0">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th class="py-3 ps-4">Service Type</th>
                                        <th class="py-3">Standard Timeline</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-4">Building Permit Approval</td>
                                        <td><span class="badge bg-light text-dark">Within 30 Working Days</span></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4">Business Operating Permit</td>
                                        <td><span class="badge bg-light text-dark">Within 5 Working Days</span></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4">Birth/Death Registration</td>
                                        <td><span class="badge bg-light text-dark">Within 2 Working Days</span></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4">Marriage Registration (Notice)</td>
                                        <td><span class="badge bg-light text-dark">21 Days Statutory Period</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h4 class="mt-5 mb-3 fw-bold">Our Responsibilities</h4>
                        <ul class="list-unstyled" style="line-height: 2;">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i> Transparent and accountable local governance.</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i> Treating all clients with respect and professional courtesy.</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i> Continuous service improvement based on your feedback.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="info-banner shadow-sm">
                        <h4 class="fw-bold mb-3"><i class="bi bi-headset me-2"></i> Complaints Unit</h4>
                        <p class="small">If you are not satisfied with our service, please contact us immediately for resolution.</p>
                        <hr class="bg-white op-50">
                        <div class="mt-3">
                            <p class="mb-2"><strong>Hotline:</strong> 0342293669</p>
                            <p class="mb-0"><strong>Email:</strong> complaints@njsma.gov.gh</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>
