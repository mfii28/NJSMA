<?php
require_once __DIR__ . '/src/init.php';

use Models\Faq;
$faqModel = new Faq();
$allFaqs = $faqModel->getAll();

// Group by category
$categorized = [];
foreach ($allFaqs as $f) {
    $categorized[$f['Category']][] = $f;
}

$pageTitle = "FAQs | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';
?>

<main id="main">
    <section class="page-header text-center">
        <div class="container">
            <h1>Frequently Asked Questions</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="<?= SITE_URL ?>" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">FAQs</li>
                </ol>
            </nav>
        </div>
    </section>

    <section id="faqs" class="faqs py-5">
        <div class="container" data-aos="fade-up">
            <div class="row g-5">
                <div class="col-lg-10 mx-auto">
                    <?php if (empty($categorized)): ?>
                    <p class="text-center py-5">No FAQs found.</p>
                    <?php else: ?>
                        <?php foreach ($categorized as $cat => $items): ?>
                        <div class="mb-5">
                            <h3 class="fw-bold mb-4 border-bottom pb-2"><?= htmlspecialchars($cat) ?></h3>
                            <div class="accordion accordion-flush shadow-sm rounded overflow-hidden" id="faqAccordion-<?= md5($cat) ?>">
                                <?php foreach ($items as $i => $item): $fid = "faq-" . $item['id']; ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $fid ?>">
                                            <?= htmlspecialchars($item['Question']) ?>
                                        </button>
                                    </h2>
                                    <div id="<?= $fid ?>" class="accordion-collapse collapse" data-bs-parent="#faqAccordion-<?= md5($cat) ?>">
                                        <div class="accordion-body text-muted" style="line-height: 1.8;">
                                            <?= nl2br(htmlspecialchars($item['Answer'])) ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>
