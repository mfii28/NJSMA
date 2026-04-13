<?php
use Models\Post;
use Models\Setting;

$postModel = new Post();
$settingModel = new Setting();

// Fetch latest posts
$latestPosts = $postModel->getAllActive(4);

// Get real stats
$totalPosts = $postModel->getCount();
$settings = $settingModel->getAllAsKeyValue();

// Dynamic section settings with fallbacks
$sectionTitle = $settings['news_section_title'] ?? 'Latest News & Updates';
$sectionSubtitle = $settings['news_section_subtitle'] ?? 'Stay Informed';
$sectionDescription = $settings['news_section_description'] ?? 'Stay updated with the latest stories, announcements, and developmental projects from the New Juaben South Municipal Assembly.';
$viewAllText = $settings['news_view_all_text'] ?? 'View All Articles';

// Get categories with post counts for dynamic badges
$db = \Core\Database::getInstance();
$categories = $db->fetchAll("
    SELECT c.CategoryName, c.id, COUNT(p.id) as post_count 
    FROM tblcategory c 
    LEFT JOIN tblposts p ON c.id = p.CategoryId AND p.Is_Active = 1 
    GROUP BY c.id, c.CategoryName 
    HAVING post_count > 0 
    ORDER BY post_count DESC 
    LIMIT 3
");

// Calculate dynamic stats
$thisMonthPosts = $db->fetch("
    SELECT COUNT(*) as count FROM tblposts 
    WHERE Is_Active = 1 AND MONTH(PostingDate) = MONTH(CURRENT_DATE()) AND YEAR(PostingDate) = YEAR(CURRENT_DATE())
")['count'] ?? 0;

$lastUpdate = !empty($latestPosts) ? strtotime($latestPosts[0]['PostingDate']) : time();
$daysSinceUpdate = floor((time() - $lastUpdate) / 86400);
?>

<!-- ======= Latest News Section ======= -->
<section id="latest-news" class="latest-news-section py-5">
    <div class="container" data-aos="fade-up">
        <!-- Section Header with Dynamic Stats -->
        <div class="row mb-5 align-items-center">
            <div class="col-lg-7">
                <div class="section-header">
                    <span class="section-subtitle">
                        <i class="bi bi-rss-fill me-2"></i><?= htmlspecialchars($sectionSubtitle) ?>
                    </span>
                    <h2 class="section-title"><?= htmlspecialchars($sectionTitle) ?></h2>
                    <p class="section-description"><?= htmlspecialchars($sectionDescription) ?></p>
                </div>
                <div class="section-actions mt-4">
                    <a href="/njsma/blogs" class="btn-view-all">
                        <span><?= htmlspecialchars($viewAllText) ?></span>
                        <i class="bi bi-arrow-right"></i>
                        <span class="btn-badge"><?= $totalPosts ?></span>
                    </a>
                    <?php if (!empty($categories)): ?>
                        <?php foreach (array_slice($categories, 0, 2) as $cat): ?>
                        <a href="/njsma/blogs?cat=<?= urlencode($cat['id']) ?>" class="btn-view-all btn-outline">
                            <i class="bi bi-folder"></i>
                            <span><?= htmlspecialchars($cat['CategoryName']) ?></span>
                            <span class="btn-badge btn-badge-muted"><?= $cat['post_count'] ?></span>
                        </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div class="blog-illustration">
                    <div class="blog-image-container">
                        <div class="blog-dynamic-stats">
                            <div class="stat-circle">
                                <span class="stat-number"><?= $totalPosts ?></span>
                                <span class="stat-label-sm">Articles</span>
                            </div>
                            <div class="stat-circle stat-circle-alt">
                                <span class="stat-number"><?= $thisMonthPosts ?></span>
                                <span class="stat-label-sm">This Month</span>
                            </div>
                        </div>
                        <?php if (!empty($categories)): ?>
                        <div class="dynamic-badges">
                            <?php foreach ($categories as $index => $cat): ?>
                            <div class="floating-badge badge-<?= $index + 1 ?>" style="animation-delay: <?= $index * 0.5 ?>s">
                                <i class="bi bi-folder-fill"></i>
                                <span><?= htmlspecialchars($cat['CategoryName']) ?></span>
                                <span class="badge-count"><?= $cat['post_count'] ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php else: ?>
                        <div class="dynamic-badges">
                            <div class="floating-badge badge-1">
                                <i class="bi bi-newspaper"></i>
                                <span>News</span>
                            </div>
                            <div class="floating-badge badge-2">
                                <i class="bi bi-calendar-check"></i>
                                <span>Events</span>
                            </div>
                            <div class="floating-badge badge-3">
                                <i class="bi bi-bell-fill"></i>
                                <span>Alerts</span>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- News Grid -->
        <div class="row g-4">
            <?php if (!empty($latestPosts)): ?>
                <?php 
                $firstPost = array_shift($latestPosts);
                ?>
                
                <!-- Featured News Card (Large) -->
                <div class="col-lg-6">
                    <article class="news-card news-card-featured" data-aos="fade-up" data-aos-delay="100">
                        <a href="/njsma/blogs?id=<?= $firstPost['id'] ?>" class="news-link">
                            <div class="news-image-wrapper">
                                <div class="image-placeholder" style="display: none;">
                                    <i class="bi bi-image"></i>
                                </div>
                                <img src="/njsma/dashboard/postimages/<?= htmlspecialchars($firstPost['PostImage'] ?: 'slider-1.jpg') ?>" 
                                     alt="<?= htmlspecialchars($firstPost['PostTitle']) ?>"
                                     class="news-image"
                                     loading="lazy"
                                     onload="this.previousElementSibling.style.display='none'"
                                     onerror="this.style.display='none'; this.previousElementSibling.style.display='flex';">
                                <div class="news-overlay"></div>
                                <div class="news-shine"></div>
                                <span class="news-badge">
                                    <i class="bi bi-star-fill me-1"></i>Featured
                                </span>
                                <div class="news-image-icon">
                                    <i class="bi bi-box-arrow-up-right"></i>
                                </div>
                            </div>
                            <div class="news-content">
                                <div class="news-meta">
                                    <span class="news-category">
                                        <i class="bi bi-folder-fill"></i>
                                        <?= htmlspecialchars($firstPost['CategoryName'] ?? 'News') ?>
                                    </span>
                                    <span class="news-dot"></span>
                                    <span class="news-date">
                                        <i class="bi bi-calendar3"></i>
                                        <?= date('F j, Y', strtotime($firstPost['PostingDate'])) ?>
                                    </span>
                                    <span class="news-dot"></span>
                                    <span class="news-readtime">
                                        <i class="bi bi-clock"></i>
                                        <?= ceil(str_word_count(strip_tags($firstPost['PostDetails'] ?? '')) / 200) ?> min read
                                    </span>
                                </div>
                                <h3 class="news-title"><?= htmlspecialchars($firstPost['PostTitle']) ?></h3>
                                <p class="news-excerpt">
                                    <?= htmlspecialchars(substr(strip_tags($firstPost['PostDetails'] ?? ''), 0, 150)) ?>...
                                </p>
                                <div class="news-footer">
                                    <span class="read-more">
                                        Read Article <i class="bi bi-arrow-right"></i>
                                    </span>
                                    <span class="news-views" data-post-id="<?= $firstPost['id'] ?>">
                                        <i class="bi bi-eye"></i>
                                        <span class="view-count"><?= $firstPost['ViewCount'] ?? rand(50, 500) ?></span> views
                                    </span>
                                </div>
                            </div>
                        </a>
                    </article>
                </div>

                <!-- Side News Cards (Stacked) -->
                <div class="col-lg-6">
                    <div class="row g-4">
                        <?php foreach ($latestPosts as $index => $post): ?>
                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="<?= ($index + 2) * 100 ?>">
                            <article class="news-card news-card-side">
                                <a href="/njsma/blogs?id=<?= $post['id'] ?>" class="news-link">
                                    <div class="news-image-wrapper">
                                        <div class="image-placeholder" style="display: none;">
                                            <i class="bi bi-image"></i>
                                        </div>
                                        <img src="/njsma/dashboard/postimages/<?= htmlspecialchars($post['PostImage'] ?: 'slider-1.jpg') ?>" 
                                             alt="<?= htmlspecialchars($post['PostTitle']) ?>"
                                             class="news-image"
                                             loading="lazy"
                                             onload="this.previousElementSibling.style.display='none'"
                                             onerror="this.style.display='none'; this.previousElementSibling.style.display='flex';">
                                        <div class="news-overlay"></div>
                                        <div class="news-shine"></div>
                                        <div class="news-hover-icon">
                                            <i class="bi bi-arrow-up-right"></i>
                                        </div>
                                    </div>
                                    <div class="news-content">
                                        <div class="news-meta">
                                            <span class="news-category" style="background: hsl(<?= rand(120, 160) ?>, 70%, 90%); color: hsl(<?= rand(120, 160) ?>, 80%, 25%);">
                                                <?= htmlspecialchars($post['CategoryName'] ?? 'News') ?>
                                            </span>
                                            <span class="news-date">
                                                <i class="bi bi-calendar3"></i>
                                                <?= date('M j', strtotime($post['PostingDate'])) ?>
                                            </span>
                                        </div>
                                        <h4 class="news-title"><?= htmlspecialchars($post['PostTitle']) ?></h4>
                                    </div>
                                </a>
                            </article>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="bi bi-newspaper"></i>
                        </div>
                        <h4>No News Available</h4>
                        <p>Check back soon for the latest updates from the Assembly.</p>
                        <a href="/njsma/dashboard/posts.php?action=new" class="btn-view-all mt-3" target="_blank">
                            <i class="bi bi-plus-lg"></i> Add First Post
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

            <!-- Dynamic Quick Stats Bar -->
        <div class="news-stats-bar mt-5 p-4 rounded-4" data-aos="fade-up" data-aos-delay="400">
            <div class="row align-items-center">
                <div class="col-md-3 text-center text-md-start mb-3 mb-md-0">
                    <div class="stat-item">
                        <div class="stat-icon-wrap">
                            <i class="bi bi-file-text-fill stat-icon"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-number-lg"><?= $totalPosts ?></span>
                            <span class="stat-text">Total Articles</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-center mb-3 mb-md-0">
                    <div class="stat-item">
                        <div class="stat-icon-wrap">
                            <i class="bi bi-calendar-event-fill stat-icon"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-number-lg"><?= $thisMonthPosts ?></span>
                            <span class="stat-text">This Month</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-center mb-3 mb-md-0">
                    <div class="stat-item">
                        <div class="stat-icon-wrap">
                            <i class="bi bi-clock-fill stat-icon"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-number-lg"><?= $daysSinceUpdate ?></span>
                            <span class="stat-text">Days Since Update</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-center text-md-end">
                    <a href="/njsma/blogs" class="btn-subscribe">
                        <i class="bi bi-bell-fill"></i>
                        <span>Browse All</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>