<?php
require_once __DIR__ . '/src/init.php';

$pageTitle = "Location & Land Size | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';

// Get location settings or use defaults
$locationContent = $GLOBAL_SETTINGS['location_content'] ?? '';
$establishedYear = $GLOBAL_SETTINGS['history_established_year'] ?? '2008';
?>

<main id="main">
    <section class="page-header text-center">
        <div class="container">
            <h1>Location & Land Size</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="/njsma/" class="text-white">Home</a></li>
                    <li class="breadcrumb-item"><a href="/njsma/about" class="text-white">About</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Location</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="location-content pb-5">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-8">
                    <div class="content-card shadow-sm mb-4">
                        <h3 class="fw-bold mb-4">Geographic Location</h3>
                        <?php if (!empty($locationContent)): ?>
                            <?= nl2br(htmlspecialchars($locationContent)) ?>
                        <?php else: ?>
                        <p class="text-muted">The New Juaben South Municipal Assembly is located in the Eastern Region of Ghana. It was established in <?= htmlspecialchars($establishedYear) ?> as part of the government's decentralization policy to bring governance closer to the people.</p>
                        
                        <h4 class="mt-4 fw-bold">Boundaries</h4>
                        <ul class="list-unstyled" style="line-height: 2;">
                            <li><i class="bi bi-geo-alt-fill text-primary me-2"></i> <strong>North:</strong> New Juaben North Municipal Assembly</li>
                            <li><i class="bi bi-geo-alt-fill text-primary me-2"></i> <strong>South:</strong> East Akim Municipal Assembly</li>
                            <li><i class="bi bi-geo-alt-fill text-primary me-2"></i> <strong>East:</strong> Akuapem North Municipal Assembly</li>
                            <li><i class="bi bi-geo-alt-fill text-primary me-2"></i> <strong>West:</strong> Suhum Municipal Assembly</li>
                        </ul>

                        <h4 class="mt-4 fw-bold">Land Size</h4>
                        <p class="text-muted">The municipality covers a total land area of approximately 220 square kilometers, making it one of the strategically located municipalities in the Eastern Region with significant potential for economic development.</p>

                        <h4 class="mt-4 fw-bold">Climate & Vegetation</h4>
                        <p class="text-muted">The municipality falls within the semi-deciduous forest zone with a tropical climate. The vegetation consists of scattered trees with grassland undergrowth in some areas, particularly suitable for agricultural activities.</p>

                        <h4 class="mt-4 fw-bold">Population</h4>
                        <p class="text-muted">According to the 2021 Population and Housing Census, the New Juaben South Municipal Assembly has a population of approximately 120,000 people with a growth rate of about 2.1% per annum.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sidebar-nav shadow-sm mb-4">
                        <h4>Key Facts</h4>
                        <ul class="list-unstyled mb-0">
                            <li><i class="bi bi-calendar me-2 text-primary"></i> Established: <?= htmlspecialchars($establishedYear) ?></li>
                            <li><i class="bi bi-map me-2 text-primary"></i> Area: ~220 km²</li>
                            <li><i class="bi bi-people me-2 text-primary"></i> Population: ~120,000</li>
                            <li><i class="bi bi-geo-alt me-2 text-primary"></i> Region: Eastern</li>
                        </ul>
                    </div>
                    <div class="info-banner shadow-sm">
                        <h4 class="fw-bold mb-3"><i class="bi bi-building me-2"></i> Capital Town</h4>
                        <p class="small">Koforidua serves as the municipal capital and is also the regional capital of the Eastern Region.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>
