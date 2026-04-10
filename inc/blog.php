<?php
use Models\Post;
$postModel = new Post();
$latestPosts = $postModel->getAllActive(3);
?>

<!-- ======= Latest News Section ======= -->
<section id="blog" class="blog">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>Latest News</h2>
            <p>Recent updates from the Assembly</p>
        </div>

        <div class="row gy-4 posts-list">
            <?php foreach ($latestPosts as $post): ?>
                <div class="col-lg-4 col-md-6">
                    <article>
                        <div class="post-img">
                            <img src="<?= SITE_URL ?>/dashboard/postimages/<?= $post['PostImage'] ?>" alt="" class="img-fluid">
                        </div>

                        <p class="post-category"><?= htmlspecialchars($post['CategoryName']) ?></p>

                        <h2 class="title">
                            <a href="blogs.php?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['PostTitle']) ?></a>
                        </h2>

                        <div class="d-flex align-items-center">
                            <div class="post-meta">
                                <p class="post-date">
                                    <time datetime="<?= $post['PostingDate'] ?>"><?= date('M d, Y', strtotime($post['PostingDate'])) ?></time>
                                </p>
                            </div>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>

            <?php if (empty($latestPosts)): ?>
                <div class="col-12 text-center">
                    <p>No news stories found at the moment.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="blog-pagination text-center mt-4">
            <a href="blogs.php" class="btn btn-primary">View All News</a>
        </div>
    </div>
</section>