<?php
require_once __DIR__ . '/src/init.php';

use Models\Document;
$docModel = new Document();

$cat = $_GET['cat'] ?? null;
if ($cat) {
    $docs = $docModel->getByCategory($cat);
    $title = "Repository: " . htmlspecialchars($cat);
} else {
    $docs = $docModel->getAll();
    $title = "Digital Repository";
}

$pageTitle = $title . " | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';
?>

<main id="main">
    <section class="page-header text-center">
        <div class="container">
            <h1><?= $title ?></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="<?= SITE_URL ?>" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Documents</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="repository pb-5">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-3">
                    <div class="sidebar-nav shadow-sm mb-4">
                        <h4>Categories</h4>
                        <ul class="list-unstyled mb-0">
                            <li><a href="?"><i class="bi bi-files me-2"></i> All Documents</a></li>
                            <li><a href="?cat=Forms"><i class="bi bi-file-earmark-text me-2"></i> Forms & Applications</a></li>
                            <li><a href="?cat=Legal"><i class="bi bi-shield-check me-2"></i> Bye-Laws & Legal</a></li>
                            <li><a href="?cat=Reports"><i class="bi bi-graph-up-arrow me-2"></i> Budget & Reports</a></li>
                            <li><a href="?cat=Permits"><i class="bi bi-diagram-3 me-2"></i> Permit Flow Charts</a></li>
                            <li><a href="?cat=Fee%20Fixing"><i class="bi bi-cash-coin me-2"></i> Fee Fixing</a></li>
                        </ul>
                    </div>

                    <div class="info-banner small p-3 mb-4">
                        <h6>Need Assistance?</h6>
                        <p class="mb-0 small">Visit our physical office for certified copies of any municipal documents.</p>
                    </div>

                    <!-- Quick Links -->
                    <div class="sidebar-nav shadow-sm mb-4">
                        <h4>Quick Links</h4>
                        <ul class="list-unstyled mb-0">
                            <li><a href="/njsma/service-processes"><i class="bi bi-arrow-right-circle me-2 text-primary"></i> Service Processes</a></li>
                            <li><a href="/njsma/location"><i class="bi bi-geo-alt me-2 text-primary"></i> Location & Land Size</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="content-card shadow-sm p-0 overflow-hidden">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" style="vertical-align: middle;">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3">Document Title</th>
                                        <th class="py-3">Category</th>
                                        <th class="py-3">Updated</th>
                                        <th class="py-3 pe-4 text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($docs as $doc): ?>
                                        <tr>
                                            <td class="ps-4">
                                                <h6 class="mb-0 fw-bold"><?= htmlspecialchars($doc['Title']) ?></h6>
                                                <span class="text-muted small"><?= htmlspecialchars($doc['Description']) ?></span>
                                            </td>
                                            <td><span class="badge rounded-pill bg-success-subtle text-success"><?= htmlspecialchars($doc['Category']) ?></span></td>
                                            <td class="text-muted small"><?= date('d M Y', strtotime($doc['UploadDate'])) ?></td>
                                            <td class="pe-4 text-end">
                                                <a href="<?= SITE_URL ?>/<?= $doc['FilePath'] ?>" class="btn btn-sm btn-primary rounded-pill px-3" download>
                                                    <i class="bi bi-download me-1"></i> Download
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>
