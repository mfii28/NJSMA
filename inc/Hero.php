<?php
use Models\HeroSlide;
$heroModel = new HeroSlide();
$slides = $heroModel->getActive();
?>
<!-- ======= Hero Section ======= -->
<section id="hero">
    <div id="heroCarousel" data-bs-interval="6000" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>
        <div class="carousel-inner" role="listbox">
            <?php if (empty($slides)): ?>
                <!-- Default slide if none in database -->
                <div class="carousel-item active" style="background-image: url(/njsma/dashboard/assets/img/heroImg/slider-1.jpg)">
                    <div class="carousel-container">
                        <div class="container text-center text-md-start">
                            <span class="badge bg-primary px-3 py-2 rounded-pill mb-3 animate__animated animate__fadeInDown">
                                <i class="bi bi-star-fill text-warning me-2"></i>Official Municipal Website
                            </span>
                            <h2 class="animate__animated animate__fadeInDown">Welcome to <span>New Juaben South</span></h2>
                            <p class="animate__animated animate__fadeInUp lead mb-4" style="max-width: 700px;">
                                Providing excellent municipal services through transparency, citizen participation, and sustainable development.
                            </p>
                            <div class="d-flex flex-wrap gap-3 animate__animated animate__fadeInUp justify-content-center justify-content-md-start">
                                <a href="<?= SITE_URL ?>/about" class="btn btn-primary rounded-pill px-4 py-2 fw-bold text-white shadow">Discover More</a>
                                <a href="<?= SITE_URL ?>/service-charter" class="btn btn-outline-light rounded-pill px-4 py-2 fw-bold shadow-sm">Our Services</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($slides as $index => $slide): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>" style="background-image: url(/njsma/dashboard/assets/img/heroImg/<?= htmlspecialchars($slide['image'] ?? 'slider-1.jpg') ?>)">
                    <div class="carousel-container">
                        <div class="container text-center text-md-start">
                            <?php if (!empty($slide['badge'])): ?>
                            <span class="badge <?= htmlspecialchars($slide['badge_class'] ?? 'bg-primary') ?> px-3 py-2 rounded-pill mb-3 animate__animated animate__fadeInDown">
                                <?= htmlspecialchars($slide['badge']) ?>
                            </span>
                            <?php endif; ?>
                            <h2 class="animate__animated animate__fadeInDown"><?= htmlspecialchars($slide['title']) ?></h2>
                            <p class="animate__animated animate__fadeInUp lead mb-4" style="max-width: 700px;">
                                <?= htmlspecialchars($slide['description']) ?>
                            </p>
                            <?php if (!empty($slide['button_1_text'])): ?>
                            <div class="d-flex flex-wrap gap-3 animate__animated animate__fadeInUp justify-content-center justify-content-md-start">
                                <a href="<?= htmlspecialchars($slide['button_1_link']) ?>" class="btn btn-primary rounded-pill px-4 py-2 fw-bold text-white shadow">
                                    <?= htmlspecialchars($slide['button_1_text']) ?>
                                </a>
                                <?php if (!empty($slide['button_2_text'])): ?>
                                <a href="<?= htmlspecialchars($slide['button_2_link']) ?>" class="btn btn-outline-light rounded-pill px-4 py-2 fw-bold shadow-sm">
                                    <?= htmlspecialchars($slide['button_2_text']) ?>
                                </a>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
        </a>
        <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
        </a>
    </div>
</section><!-- End Hero -->
