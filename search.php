<?php
require_once __DIR__ . '/src/init.php';

use Models\Post;

$postModel = new Post();
$searchTerm = $_GET['s'] ?? '';
$page = (int)($_GET['page'] ?? 1);
$limit = 8;
$offset = ($page - 1) * $limit;

$results = [];
if (!empty($searchTerm)) {
    $results = $postModel->search($searchTerm, $limit, $offset);
    $totalRecords = $postModel->getCount($searchTerm);
} else {
    $results = $postModel->getAllActive($limit, $offset);
    $totalRecords = $postModel->getCount();
}

$totalPages = ceil($totalRecords / $limit);

$pageTitle = "Search Results for '" . htmlspecialchars($searchTerm) . "' | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';
?>

<main id="main">
    <section class="page-header text-center">
        <div class="container">
            <h1>Search News & Updates</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent mt-2">
                    <li class="breadcrumb-item"><a href="<?= SITE_URL ?>/" class="text-white"><i class="bi bi-house-door me-1"></i> Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Search</li>
                </ol>
            </nav>
        </div>
    </section>

    <section id="blog" class="blog pb-5">
        <div class="container" data-aos="fade-up">

            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-2">Search Results</span>
                        <h3 class="fw-bold"><?= !empty($searchTerm) ? "Results for: '" . htmlspecialchars($searchTerm) . "'" : "All Latest Stories" ?></h3>
                    </div>

                    <div class="news-items-list mb-5">
                        <?php foreach ($results as $post): ?>
                            <a href="<?= SITE_URL ?>/blogs?id=<?= $post['id'] ?>" class="news-card-horizontal mb-3 d-flex flex-column flex-md-row align-items-center shadow-sm" style="background: #fff; padding: 20px; border-radius: 12px; text-decoration: none; color: inherit;">
                                <div class="news-card-img me-0 me-md-4 mb-3 mb-md-0" style="width: 100%; max-width: 250px; height: 160px; overflow: hidden; border-radius: 8px;">
                                    <img src="<?= SITE_URL ?>/dashboard/postimages/<?= $post['PostImage'] ?>" alt="<?= htmlspecialchars($post['PostTitle']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div class="news-card-content flex-grow-1">
                                    <div class="mb-2">
                                        <span class="cat text-warning fw-bold small text-uppercase"><?= htmlspecialchars($post['CategoryName']) ?></span>
                                        <span class="date text-muted ms-3 small"><i class="bi bi-calendar3 me-1"></i> <?= date('M d, Y', strtotime($post['PostingDate'])) ?></span>
                                    </div>
                                    <h3 class="mb-3 text-dark fw-bold" style="font-size: 1.25rem;">
                                        <?= htmlspecialchars($post['PostTitle']) ?>
                                    </h3>
                                    <div class="d-flex align-items-center mt-auto">
                                        <span class="text-primary fw-bold small">Read More <i class="bi bi-arrow-right ms-1"></i></span>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>

                        <?php if (empty($results)): ?>
                            <div class="text-center py-5 bg-light rounded-3">
                                <i class="bi bi-search" style="font-size: 3rem; color: #ccc;"></i>
                                <h4 class="mt-3 text-muted">No news articles found matching your search.</h4>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if ($totalPages > 1): ?>
                        <div class="custom-pagination mt-4">
                            <ul class="justify-content-center list-unstyled d-flex gap-2">
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="<?= $page == $i ? 'active' : '' ?>">
                                        <a href="?s=<?= urlencode($searchTerm) ?>&page=<?= $i ?>" class="btn <?= $page == $i ? 'btn-primary' : 'btn-outline-primary' ?> rounded-circle fw-bold" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-lg-4">
                    <?php include ROOT_PATH . '/inc/sidebar.php'; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>