<?php
use Models\Post;
$postModel = new Post();
$latestPosts = $postModel->getAllActive(3);
?>

<!-- ======= Latest News Section ======= -->
<section id="latest-news" class="latest-news py-5">
    <div class="container" data-aos="fade-up">
        <div class="latest-news-grid">
            <!-- Left Info Column -->
            <div class="news-intro">
                <h2>Latest <br>News</h2>
                <p>Stay updated with the latest stories, announcements, and developmental projects from the New Juaben South Municipal Assembly.</p>
                <a href="/njsma/blogs" class="view-all-news">
                    View All News
                    <div class="view-all-circle">
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </a>
            </div>

            <!-- Right News List Column -->
            <div class="news-items-list">
                <?php foreach ($latestPosts as $post): ?>
                    <a href="/njsma/blogs?id=<?= $post['id'] ?>" class="news-card-horizontal">
                        <div class="news-card-img">
                            <img src="/njsma/dashboard/postimages/<?= $post['PostImage'] ?: 'slider-1.jpg' ?>" alt="">
                        </div>
                        <div class="news-card-content">
                            <span class="cat"><?= htmlspecialchars($post['CategoryName']) ?></span>
                            <span class="date"><?= date('F Y', strtotime($post['PostingDate'])) ?></span>
                            <h3><?= htmlspecialchars($post['PostTitle']) ?></h3>
                        </div>
                        <div class="news-arrow">
                            <i class="bi bi-arrow-up-right"></i>
                        </div>
                    </a>
                <?php endforeach; ?>

                <?php if (empty($latestPosts)): ?>
                    <div class="text-center p-4">
                        <p>No news stories found at the moment.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>