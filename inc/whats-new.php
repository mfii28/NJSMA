<?php
use Models\Post;
$postModel = new Post();
$latestPosts = $postModel->getAllActive(6, 0);
?>
<!-- ======= What's New Section ======= -->
<section id="whats-new" class="whats-new py-5 bg-light">
    <div class="container" data-aos="fade-up">
        <div class="row g-4">
            <!-- Left Column - News Carousel -->
            <div class="col-lg-8">
                <h2 class="section-title mb-4">What's New</h2>
                
                <?php if (!empty($latestPosts)): ?>
                <div id="newsCarousel" class="carousel slide news-carousel" data-bs-ride="carousel">
                    <div class="carousel-inner rounded-4 overflow-hidden shadow-sm">
                        <?php foreach ($latestPosts as $index => $post): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <div class="news-card">
                                <div class="news-image">
                                    <img src="<?= SITE_URL ?>/assets/img/<?= htmlspecialchars($post['PostImage'] ?? 'slider-1.jpg') ?>" 
                                         alt="<?= htmlspecialchars($post['PostTitle']) ?>" 
                                         class="img-fluid w-100">
                                </div>
                                <div class="news-content p-4 bg-white">
                                    <h4 class="news-title mb-2">
                                        <a href="/news-details.php?id=<?= $post['id'] ?>" class="text-decoration-none text-dark">
                                            <?= htmlspecialchars($post['PostTitle']) ?>
                                        </a>
                                    </h4>
                                    <div class="news-meta d-flex align-items-center text-muted">
                                        <i class="bi bi-calendar3 me-2"></i>
                                        <span><?= date('d M, Y', strtotime($post['PostingDate'])) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Carousel Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    
                    <!-- Carousel Indicators -->
                    <div class="carousel-indicators mt-3 position-static">
                        <?php foreach ($latestPosts as $index => $post): ?>
                        <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="<?= $index ?>" 
                                class="<?= $index === 0 ? 'active' : '' ?>" aria-current="<?= $index === 0 ? 'true' : 'false' ?>"></button>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php else: ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    No news available at the moment. Check back soon!
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Right Column - Quote/Testimonial -->
            <div class="col-lg-4">
                <div class="quote-card h-100 rounded-4 overflow-hidden shadow-sm">
                    <div class="quote-image">
                        <img src="<?= SITE_URL ?>/assets/img/mce-message.jpg" 
                             alt="MCE Quote" 
                             class="img-fluid w-100 h-100 object-fit-cover">
                    </div>
                    <div class="quote-content p-4 bg-success text-white">
                        <div class="quote-icon mb-3">
                            <i class="bi bi-quote fs-1"></i>
                        </div>
                        <blockquote class="mb-3">
                            <p class="mb-0 fst-italic">
                                "Real leadership requires understanding the daily struggles of citizens and crafting practical interventions that improve their living conditions."
                            </p>
                        </blockquote>
                        <div class="quote-author">
                            <strong>- Hon. Municipal Chief Executive</strong>
                        </div>
                        <div class="quote-logo mt-3">
                            <span class="badge bg-white text-success px-3 py-2">
                                <i class="bi bi-building me-1"></i>
                                NJSMA
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- End What's New Section -->
