<?php
require_once __DIR__ . '/src/init.php';

$db = \Core\Database::getInstance();
$programs = $db->fetchAll("SELECT * FROM tbloutreach_programs WHERE is_active = 1 ORDER BY event_date DESC");

$pageTitle = "Information Service & Outreach | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';
?>

<main id="main">
    <section class="page-header text-center">
        <div class="container">
            <h1>Information Service Department</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="/njsma/" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Information Service</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="info-service-content pb-5">
        <div class="container" data-aos="fade-up">
            <!-- Department Overview -->
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="fw-bold mb-4">Bridging the Gap Between Government and Citizens</h2>
                    <p class="text-muted lead">The Information Service Department is tasked with the responsibility of sensitizing and educating citizens on various government programs, policies, and activities within the New Juaben South Municipality.</p>
                </div>
            </div>

            <!-- Core Functions -->
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="content-card shadow-sm h-100 text-center p-4">
                        <div class="icon-box bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width:70px;height:70px;">
                            <i class="bi bi-broadcast fs-2"></i>
                        </div>
                        <h4 class="fw-bold">Radio Programs</h4>
                        <p class="text-muted">Regular radio broadcasts to educate the general public on government programs, policies, and developmental projects.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="content-card shadow-sm h-100 text-center p-4">
                        <div class="icon-box bg-success text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width:70px;height:70px;">
                            <i class="bi bi-heart-pulse fs-2"></i>
                        </div>
                        <h4 class="fw-bold">Health Screenings</h4>
                        <p class="text-muted">Organizing health screening exercises and wellness programs in communities across the municipality.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="content-card shadow-sm h-100 text-center p-4">
                        <div class="icon-box bg-info text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width:70px;height:70px;">
                            <i class="bi bi-people fs-2"></i>
                        </div>
                        <h4 class="fw-bold">Community Engagement</h4>
                        <p class="text-muted">Direct engagement with communities through town hall meetings and MCE community visits.</p>
                    </div>
                </div>
            </div>

            <!-- Key Activities -->
            <div class="row mb-5">
                <div class="col-lg-12">
                    <div class="content-card shadow-sm p-4">
                        <h3 class="fw-bold mb-4 border-bottom pb-3">Key Activities</h3>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <i class="bi bi-check-circle-fill text-primary me-3 fs-4"></i>
                                    <div>
                                        <h5 class="fw-bold">Public Education</h5>
                                        <p class="text-muted small">Sensitizing citizens on government policies, programs, and developmental initiatives.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <i class="bi bi-check-circle-fill text-primary me-3 fs-4"></i>
                                    <div>
                                        <h5 class="fw-bold">MCE Community Tours</h5>
                                        <p class="text-muted small">Organizing community engagement sessions with the Municipal Chief Executive.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <i class="bi bi-check-circle-fill text-primary me-3 fs-4"></i>
                                    <div>
                                        <h5 class="fw-bold">Health Promotion</h5>
                                        <p class="text-muted small">Coordinating health screening exercises and public health education campaigns.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <i class="bi bi-check-circle-fill text-primary me-3 fs-4"></i>
                                    <div>
                                        <h5 class="fw-bold">Media Relations</h5>
                                        <p class="text-muted small">Managing radio programs and media communications for the Assembly.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <i class="bi bi-check-circle-fill text-primary me-3 fs-4"></i>
                                    <div>
                                        <h5 class="fw-bold">Civic Education</h5>
                                        <p class="text-muted small">Educating citizens on their rights, responsibilities, and local governance processes.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <i class="bi bi-check-circle-fill text-primary me-3 fs-4"></i>
                                    <div>
                                        <h5 class="fw-bold">Event Coverage</h5>
                                        <p class="text-muted small">Documenting and publicizing Assembly programs and community events.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Outreach Programs / Upcoming Events -->
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="fw-bold mb-4">Outreach Programs & Events</h3>
                    <?php if (empty($programs)): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i> No upcoming outreach programs scheduled. Check back soon for updates on community engagement activities.
                    </div>
                    <?php else: ?>
                    <div class="row g-4">
                        <?php foreach ($programs as $program): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="content-card shadow-sm h-100">
                                <?php if ($program['image']): ?>
                                <img src="/njsma/dashboard/assets/img/events/<?= htmlspecialchars($program['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($program['title']) ?>" style="height:200px;object-fit:cover;">
                                <?php endif; ?>
                                <div class="p-4">
                                    <span class="badge bg-primary mb-2"><?= htmlspecialchars($program['category'] ?? 'Outreach') ?></span>
                                    <h5 class="fw-bold mb-2"><?= htmlspecialchars($program['title']) ?></h5>
                                    <p class="text-muted small mb-3"><?= htmlspecialchars(substr($program['description'], 0, 100)) ?>...</p>
                                    <div class="d-flex align-items-center text-muted small">
                                        <i class="bi bi-calendar me-2"></i>
                                        <?= date('F d, Y', strtotime($program['event_date'])) ?>
                                    </div>
                                    <?php if ($program['location']): ?>
                                    <div class="d-flex align-items-center text-muted small mt-1">
                                        <i class="bi bi-geo-alt me-2"></i>
                                        <?= htmlspecialchars($program['location']) ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="info-banner shadow-sm">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="fw-bold mb-2"><i class="bi bi-headset me-2"></i> Contact the Information Service Department</h4>
                                <p class="mb-0">For inquiries about outreach programs, radio schedules, or to request the MCE for community engagements.</p>
                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <a href="/njsma/contact" class="btn btn-light">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>
