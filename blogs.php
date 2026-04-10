<?php
require_once __DIR__ . '/src/init.php';

use Models\Post;
$postModel = new Post();

$postId = $_GET['id'] ?? null;

if ($postId) {
    // Single Post View
    $sql = "SELECT p.*, c.CategoryName 
            FROM tblposts p 
            LEFT JOIN tblcategory c ON p.CategoryId = c.id 
            WHERE p.id = :id AND p.Is_Active = 1";
    $post = Core\Database::getInstance()->fetch($sql, ['id' => (int)$postId]);

    if (!$post) {
        header("Location: blogs.php");
        exit;
    }

    $pageTitle = $post['PostTitle'] . " | " . SITE_NAME;
    include VIEW_PATH . '/partials/header.php';
    ?>
    <main id="main">
        <section class="blog-details mt-5">
            <div class="container" data-aos="fade-up">
                <div class="row g-5">
                    <div class="col-lg-8">
                        <article class="blog-details">
                            <div class="post-img">
                                <img src="<?= SITE_URL ?>/dashboard/postimages/<?= $post['PostImage'] ?>" alt="" class="img-fluid rounded">
                            </div>
                            <h2 class="title mt-4"><?= htmlspecialchars($post['PostTitle']) ?></h2>
                            <div class="meta-top">
                                <ul class="list-unstyled d-flex text-muted">
                                    <li class="me-3"><i class="bi bi-clock"></i> <?= date('M d, Y', strtotime($post['PostingDate'])) ?></li>
                                    <li><i class="bi bi-folder"></i> <?= htmlspecialchars($post['CategoryName']) ?></li>
                                </ul>
                            </div>
                            <div class="content mt-4">
                                <?= $post['PostDetails'] ?>
                            </div>
                        </article>
                    </div>
                    <div class="col-lg-4">
                        <?php include ROOT_PATH . '/inc/sidebar.php'; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php
} else {
    // List View
    $page = (int)($_GET['page'] ?? 1);
    $limit = 6;
    $offset = ($page - 1) * $limit;
    
    $posts = $postModel->getAllActive($limit, $offset);
    $totalRecords = $postModel->getCount();
    $totalPages = ceil($totalRecords / $limit);

    $pageTitle = "News & Updates | " . SITE_NAME;
    include VIEW_PATH . '/partials/header.php';
    ?>
    <main id="main">
        <section id="blog" class="blog mt-5">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>News & Updates</h2>
                    <p>Recent stories from our municipality</p>
                </div>
                <div class="row gy-4 posts-list">
                    <?php foreach ($posts as $post): ?>
                        <div class="col-lg-4 col-md-6">
                            <article>
                                <div class="post-img">
                                    <img src="<?= SITE_URL ?>/dashboard/postimages/<?= $post['PostImage'] ?>" alt="" class="img-fluid">
                                </div>
                                <p class="post-category"><?= htmlspecialchars($post['CategoryName']) ?></p>
                                <h2 class="title">
                                    <a href="?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['PostTitle']) ?></a>
                                </h2>
                                <div class="d-flex align-items-center">
                                    <div class="post-meta">
                                        <p class="post-date"><?= date('M d, Y', strtotime($post['PostingDate'])) ?></p>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <div class="blog-pagination text-center mt-5">
                        <ul class="justify-content-center">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="<?= $page == $i ? 'active' : '' ?>">
                                    <a href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <?php
}

include VIEW_PATH . '/partials/footer.php';
?>