<?php
require_once __DIR__ . '/src/init.php';

$db = \Core\Database::getInstance();
$processes = $db->fetchAll("SELECT * FROM tblservice_processes WHERE is_active = 1 ORDER BY display_order ASC");

$pageTitle = "Service Processes | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';
?>

<main id="main">
    <section class="page-header text-center">
        <div class="container">
            <h1>Service Delivery Processes</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="/njsma/" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Service Processes</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="service-processes pb-5">
        <div class="container" data-aos="fade-up">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="fw-bold">How to Access Our Services</h2>
                    <p class="text-muted">Step-by-step guides to help you navigate our service delivery processes. Click on any service to view detailed requirements and procedures.</p>
                </div>
            </div>

            <?php if (empty($processes)): ?>
            <!-- Default content if no processes in database -->
            <div class="row g-4">
                <!-- Building Permit -->
                <div class="col-lg-6">
                    <div class="content-card shadow-sm h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;">
                                <i class="bi bi-building fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-0">Building Permit Application</h4>
                        </div>
                        <div class="process-steps">
                            <div class="step d-flex mb-3">
                                <span class="step-number bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:30px;height:30px;min-width:30px;">1</span>
                                <div>
                                    <h6 class="fw-bold mb-1">Submit Application</h6>
                                    <p class="text-muted small mb-0">Complete application form with site plan and architectural drawings.</p>
                                </div>
                            </div>
                            <div class="step d-flex mb-3">
                                <span class="step-number bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:30px;height:30px;min-width:30px;">2</span>
                                <div>
                                    <h6 class="fw-bold mb-1">Site Inspection</h6>
                                    <p class="text-muted small mb-0">Physical Planning Department conducts site inspection.</p>
                                </div>
                            </div>
                            <div class="step d-flex mb-3">
                                <span class="step-number bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:30px;height:30px;min-width:30px;">3</span>
                                <div>
                                    <h6 class="fw-bold mb-1">Fee Assessment</h6>
                                    <p class="text-muted small mb-0">Payment of processing fees based on building type.</p>
                                </div>
                            </div>
                            <div class="step d-flex">
                                <span class="step-number bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:30px;height:30px;min-width:30px;">4</span>
                                <div>
                                    <h6 class="fw-bold mb-1">Permit Issuance</h6>
                                    <p class="text-muted small mb-0">Collect building permit within 30 working days.</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-top">
                            <span class="badge bg-light text-dark border me-2"><i class="bi bi-clock me-1"></i> 30 Days</span>
                            <a href="/njsma/repository" class="badge bg-primary text-white text-decoration-none">View Requirements</a>
                        </div>
                    </div>
                </div>

                <!-- Business Operating Permit -->
                <div class="col-lg-6">
                    <div class="content-card shadow-sm h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;">
                                <i class="bi bi-shop fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-0">Business Operating Permit</h4>
                        </div>
                        <div class="process-steps">
                            <div class="step d-flex mb-3">
                                <span class="step-number bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:30px;height:30px;min-width:30px;">1</span>
                                <div>
                                    <h6 class="fw-bold mb-1">Register Business</h6>
                                    <p class="text-muted small mb-0">Register with Registrar General's Department.</p>
                                </div>
                            </div>
                            <div class="step d-flex mb-3">
                                <span class="step-number bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:30px;height:30px;min-width:30px;">2</span>
                                <div>
                                    <h6 class="fw-bold mb-1">Apply at Assembly</h6>
                                    <p class="text-muted small mb-0">Submit application with business registration documents.</p>
                                </div>
                            </div>
                            <div class="step d-flex mb-3">
                                <span class="step-number bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:30px;height:30px;min-width:30px;">3</span>
                                <div>
                                    <h6 class="fw-bold mb-1">Inspection</h6>
                                    <p class="text-muted small mb-0">Premises inspection by Environmental Health Unit.</p>
                                </div>
                            </div>
                            <div class="step d-flex">
                                <span class="step-number bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:30px;height:30px;min-width:30px;">4</span>
                                <div>
                                    <h6 class="fw-bold mb-1">Pay Fees & Collect</h6>
                                    <p class="text-muted small mb-0">Pay permit fees and collect operating permit.</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-top">
                            <span class="badge bg-light text-dark border me-2"><i class="bi bi-clock me-1"></i> 5 Days</span>
                            <a href="/njsma/repository" class="badge bg-success text-white text-decoration-none">View Requirements</a>
                        </div>
                    </div>
                </div>

                <!-- Birth Registration -->
                <div class="col-lg-6">
                    <div class="content-card shadow-sm h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;">
                                <i class="bi bi-person-badge fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-0">Birth Registration</h4>
                        </div>
                        <div class="process-steps">
                            <div class="step d-flex mb-3">
                                <span class="step-number bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:30px;height:30px;min-width:30px;">1</span>
                                <div>
                                    <h6 class="fw-bold mb-1">Visit Registry</h6>
                                    <p class="text-muted small mb-0">Visit Births and Deaths Registry within 21 days of birth.</p>
                                </div>
                            </div>
                            <div class="step d-flex mb-3">
                                <span class="step-number bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:30px;height:30px;min-width:30px;">2</span>
                                <div>
                                    <h6 class="fw-bold mb-1">Provide Information</h6>
                                    <p class="text-muted small mb-0">Submit hospital birth notification and parents' IDs.</p>
                                </div>
                            </div>
                            <div class="step d-flex">
                                <span class="step-number bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:30px;height:30px;min-width:30px;">3</span>
                                <div>
                                    <h6 class="fw-bold mb-1">Certificate Issued</h6>
                                    <p class="text-muted small mb-0">Pay registration fee and collect birth certificate.</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-top">
                            <span class="badge bg-light text-dark border me-2"><i class="bi bi-clock me-1"></i> 2 Days</span>
                            <span class="badge bg-info text-white">Free (within 21 days)</span>
                        </div>
                    </div>
                </div>

                <!-- Marriage Registration -->
                <div class="col-lg-6">
                    <div class="content-card shadow-sm h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;">
                                <i class="bi bi-heart fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-0">Marriage Registration</h4>
                        </div>
                        <div class="process-steps">
                            <div class="step d-flex mb-3">
                                <span class="step-number bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center me-3" style="width:30px;height:30px;min-width:30px;">1</span>
                                <div>
                                    <h6 class="fw-bold mb-1">Give Notice</h6>
                                    <p class="text-muted small mb-0">Submit notice of marriage 21 days before ceremony.</p>
                                </div>
                            </div>
                            <div class="step d-flex mb-3">
                                <span class="step-number bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center me-3" style="width:30px;height:30px;min-width:30px;">2</span>
                                <div>
                                    <h6 class="fw-bold mb-1">Publication</h6>
                                    <p class="text-muted small mb-0">Notice published on Assembly notice board for 21 days.</p>
                                </div>
                            </div>
                            <div class="step d-flex mb-3">
                                <span class="step-number bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center me-3" style="width:30px;height:30px;min-width:30px;">3</span>
                                <div>
                                    <h6 class="fw-bold mb-1">Ceremony</h6>
                                    <p class="text-muted small mb-0">Marriage conducted by authorized officer.</p>
                                </div>
                            </div>
                            <div class="step d-flex">
                                <span class="step-number bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center me-3" style="width:30px;height:30px;min-width:30px;">4</span>
                                <div>
                                    <h6 class="fw-bold mb-1">Certificate</h6>
                                    <p class="text-muted small mb-0">Collect marriage certificate after registration.</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-top">
                            <span class="badge bg-light text-dark border me-2"><i class="bi bi-clock me-1"></i> 21 Days Notice</span>
                            <a href="/njsma/contact" class="badge bg-warning text-dark text-decoration-none">Book Appointment</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <!-- Dynamic processes from database -->
            <div class="row g-4">
                <?php foreach ($processes as $process): ?>
                <div class="col-lg-6">
                    <div class="content-card shadow-sm h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box bg-<?= htmlspecialchars($process['color_code'] ?? 'primary') ?> text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;">
                                <i class="bi bi-<?= htmlspecialchars($process['icon'] ?? 'check') ?> fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-0"><?= htmlspecialchars($process['title']) ?></h4>
                        </div>
                        <div class="process-steps">
                            <?= $process['steps_html'] ?>
                        </div>
                        <div class="mt-3 pt-3 border-top">
                            <?php if ($process['timeline']): ?>
                            <span class="badge bg-light text-dark border me-2"><i class="bi bi-clock me-1"></i> <?= htmlspecialchars($process['timeline']) ?></span>
                            <?php endif; ?>
                            <?php if ($process['document_link']): ?>
                            <a href="<?= htmlspecialchars($process['document_link']) ?>" class="badge bg-<?= htmlspecialchars($process['color_code'] ?? 'primary') ?> text-white text-decoration-none">View Requirements</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>
