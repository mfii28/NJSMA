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
        header("Location: /njsma/blogs");
        exit;
    }

    $pageTitle = $post['PostTitle'] . " | " . SITE_NAME;
    include VIEW_PATH . '/partials/header.php';
    ?>
    <main id="main">
        <section class="page-header text-center">
            <div class="container">
                <h1 class="text-truncate"><?= htmlspecialchars($post['PostTitle']) ?></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center bg-transparent">
                        <li class="breadcrumb-item"><a href="<?= SITE_URL ?>" class="text-white">Home</a></li>
                        <li class="breadcrumb-item"><a href="/njsma/blogs" class="text-white">News</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Post Details</li>
                    </ol>
                </nav>
            </div>
        </section>

        <section class="blog-details pb-5">
            <div class="container" data-aos="fade-up">
                <div class="row g-5">
                    <div class="col-lg-8">
                        <div class="content-card shadow-sm">
                            <article>
                                <div class="post-img mb-4">
                                    <img src="/njsma/dashboard/postimages/<?= $post['PostImage'] ?>" alt="" class="img-fluid rounded-4 shadow-sm w-100">
                                </div>
                                <div class="meta-top mb-4 d-flex gap-4 small text-muted border-bottom pb-3">
                                    <span><i class="bi bi-calendar3 me-2 text-primary"></i> <?= date('F d, Y', strtotime($post['PostingDate'])) ?></span>
                                    <span><i class="bi bi-tag me-2 text-primary"></i> <?= htmlspecialchars($post['CategoryName']) ?></span>
                                </div>
                                <div class="content post-details-text" style="line-height: 1.8; font-size: 17px; color: #444;">
                                    <?= $post['PostDetails'] ?>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="sidebar-nav shadow-sm mb-4">
                            <h4>Recent News</h4>
                            <?php 
                            $recent = $postModel->getAllActive(3, 0);
                            foreach($recent as $rp): if($rp['id'] == $post['id']) continue;
                            ?>
                                <div class="mb-4">
                                    <h6 class="fw-bold mb-1"><a href="?id=<?= $rp['id'] ?>" class="text-dark text-decoration-none"><?= htmlspecialchars($rp['PostTitle']) ?></a></h6>
                                    <small class="text-muted"><?= date('M d, Y', strtotime($rp['PostingDate'])) ?></small>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="info-banner shadow-sm p-4 text-center">
                            <h5 class="fw-bold mb-3">Newsletter</h5>
                            <p class="small mb-3">Get the latest municipal news directly in your inbox.</p>
                            <input type="email" class="form-control mb-2" placeholder="Email Address">
                            <button class="btn btn-light w-100">Subscribe Now</button>
                        </div>
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
        <section class="page-header text-center">
            <div class="container">
                <h1>News & Updates</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center bg-transparent">
                        <li class="breadcrumb-item"><a href="<?= SITE_URL ?>" class="text-white">Home</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">News Feed</li>
                    </ol>
                </nav>
            </div>
        </section>

        <section id="blog" class="blog pb-5">
            <div class="container" data-aos="fade-up">
                <div class="row g-4">
                    <?php if (empty($posts)): ?>
                        <div class="col-12">
                            <div class="content-card text-center py-5 shadow-sm">
                                <h4>No News Found</h4>
                                <p class="text-muted">We haven't posted any updates recently. Please check back soon.</p>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($posts as $post): ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="blog-post-card">
                                    <div class="blog-img">
                                        <img src="/njsma/dashboard/postimages/<?= $post['PostImage'] ?>" alt="<?= htmlspecialchars($post['PostTitle']) ?>">
                                    </div>
                                    <div class="blog-content">
                                        <span class="blog-cat"><?= htmlspecialchars($post['CategoryName']) ?></span>
                                        <h4 class="blog-title">
                                            <a href="?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['PostTitle']) ?></a>
                                        </h4>
                                        <div class="blog-footer">
                                            <i class="bi bi-calendar3 me-2"></i> <?= date('M d, Y', strtotime($post['PostingDate'])) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <div class="custom-pagination">
                        <ul>
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