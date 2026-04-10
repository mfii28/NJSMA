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
    <section id="blog" class="blog mt-5">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Search Results</h2>
                <p><?= !empty($searchTerm) ? "Showing results for '" . htmlspecialchars($searchTerm) . "'" : "Latest Stories" ?></p>
            </div>

            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="row gy-4 posts-list">
                        <?php foreach ($results as $post): ?>
                            <div class="col-12">
                                <article class="d-flex align-items-center mb-4">
                                    <div class="post-img me-4" style="width: 200px;">
                                        <img src="<?= SITE_URL ?>/dashboard/postimages/<?= $post['PostImage'] ?>" alt="" class="img-fluid">
                                    </div>
                                    <div>
                                        <h2 class="title" style="font-size: 1.5rem;">
                                            <a href="blogs.php?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['PostTitle']) ?></a>
                                        </h2>
                                        <p class="post-date text-muted">
                                            <?= date('M d, Y', strtotime($post['PostingDate'])) ?> | <?= htmlspecialchars($post['CategoryName']) ?>
                                        </p>
                                    </div>
                                </article>
                            </div>
                        <?php endforeach; ?>

                        <?php if (empty($results)): ?>
                            <p>No results found for your search.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if ($totalPages > 1): ?>
                        <div class="blog-pagination mt-4">
                            <ul class="justify-content-center">
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="<?= $page == $i ? 'active' : '' ?>">
                                        <a href="?s=<?= urlencode($searchTerm) ?>&page=<?= $i ?>"><?= $i ?></a>
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