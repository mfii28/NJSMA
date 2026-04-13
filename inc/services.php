<?php
use Models\Service;
$serviceModel = new Service();
$services = $serviceModel->getAllActive();
?>
<!-- ======= Our Services Section ======= -->
<section id="services" class="services py-5">
    <div class="container" data-aos="fade-up">
        <div class="section-title text-center mb-5">
            <h2 class="fw-bold" style="color: var(--primary-color);">Municipal Services</h2>
            <p class="text-muted">Access essential services and permits provided by the Assembly</p>
        </div>

        <div class="row g-4">
            <?php if (empty($services)): ?>
                <div class="col-12 text-center">
                    <p class="text-muted">No services listed at the moment. Please check back later.</p>
                </div>
            <?php else: ?>
                <?php foreach ($services as $service): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="service-box-new">
                        <div class="service-icon">
                            <i class="bi <?= htmlspecialchars($service['icon'] ?? 'bi-briefcase') ?>"></i>
                        </div>
                        <div class="service-details">
                            <h3><?= htmlspecialchars($service['title']) ?></h3>
                            <p><?= htmlspecialchars($service['description']) ?></p>
                            <?php if (!empty($service['link'])): ?>
                            <a href="<?= htmlspecialchars($service['link']) ?>" class="service-link">
                                <?= htmlspecialchars($service['link_text'] ?? 'Learn More') ?> <i class="bi bi-arrow-right"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section><!-- End Our Services Section -->

