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
    <section class="breadcrumbs d-flex align-items-center" style="background-image: url('dashboard/assets/img/heroImg/slider-1.jpg'); height: 200px; background-size: cover;">
        <div class="container text-center">
            <h2 class="text-white"><?= $title ?></h2>
        </div>
    </section>

    <section class="repository mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="sidebar-box p-4 bg-light">
                        <h4>Categories</h4>
                        <ul class="list-unstyled">
                            <li><a href="?">All Documents</a></li>
                            <li><a href="?cat=Forms">Forms & Applications</a></li>
                            <li><a href="?cat=Legal">Bye-Laws & Legal</a></li>
                            <li><a href="?cat=Reports">Budget & Reports</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Updated</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($docs as $doc): ?>
                                    <tr>
                                        <td>
                                            <h6 class="mb-0"><?= htmlspecialchars($doc['Title']) ?></h6>
                                            <small class="text-muted"><?= htmlspecialchars($doc['Description']) ?></small>
                                        </td>
                                        <td><span class="badge bg-info text-dark"><?= htmlspecialchars($doc['Category']) ?></span></td>
                                        <td><?= date('d M Y', strtotime($doc['UploadDate'])) ?></td>
                                        <td>
                                            <a href="<?= SITE_URL ?>/<?= $doc['FilePath'] ?>" class="btn btn-sm btn-outline-primary" download>
                                                <i class="bi bi-download"></i> Download
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
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>
