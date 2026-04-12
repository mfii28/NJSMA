<?php
require_once __DIR__ . '/src/init.php';

use Models\MceModel;
$mceModel = new MceModel();
$mce = $mceModel->getMceInfo();

$pageTitle = "The MCE | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';

// Get MCE data with fallbacks
$firstName = $mce['first_name'] ?? '';
$lastName = $mce['last_name'] ?? '';
$fullName = trim($firstName . ' ' . $lastName) ?: 'Municipal Chief Executive';
$title = $mce['title'] ?? 'Municipal Chief Executive';
$biography = $mce['biography'] ?? '';
$vision = $mce['vision'] ?? '';
$education = $mce['education'] ?? '';
$image = $mce['image'] ?? 'mce.jpg';
$email = $mce['email'] ?? '';
$phone = $mce['phone'] ?? '';
$contactEmail = $mce['contact_email'] ?? 'info@njsma.gov.gh';
$socialFacebook = $mce['social_facebook'] ?? '';
$socialTwitter = $mce['social_twitter'] ?? '';
$socialLinkedin = $mce['social_linkedin'] ?? '';
$termStart = $mce['term_start'] ?? '';
$termEnd = $mce['term_end'] ?? '';
?>

<main id="main">
    <section class="page-header text-center">
        <div class="container">
            <h1>The MCE's Office</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="/njsma/" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">The MCE</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="the-mayor-details pb-5">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-4">
                    <div class="dept-head-box shadow-sm text-center">
                        <img src="/njsma/dashboard/assets/img/profileImg/<?= htmlspecialchars($image) ?>" class="img-fluid rounded mb-3" alt="<?= htmlspecialchars($fullName) ?>" style="max-height:300px;object-fit:cover;">
                        <div class="mt-3">
                            <h3 class="fw-bold text-primary">Hon. <?= htmlspecialchars($fullName) ?></h3>
                            <p class="text-muted text-uppercase small letter-spacing-1"><?= htmlspecialchars($title) ?></p>
                            <?php if ($termStart): ?>
                            <small class="text-muted">Term: <?= date('Y', strtotime($termStart)) ?> - <?= $termEnd ? date('Y', strtotime($termEnd)) : 'Present' ?></small>
                            <?php endif; ?>
                        </div>
                        <?php if ($socialFacebook || $socialTwitter || $socialLinkedin): ?>
                        <div class="social-links mt-4 d-flex justify-content-center gap-3">
                            <?php if ($socialFacebook): ?>
                            <a href="<?= htmlspecialchars($socialFacebook) ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle"><i class="bi bi-facebook"></i></a>
                            <?php endif; ?>
                            <?php if ($socialTwitter): ?>
                            <a href="<?= htmlspecialchars($socialTwitter) ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle"><i class="bi bi-twitter-x"></i></a>
                            <?php endif; ?>
                            <?php if ($socialLinkedin): ?>
                            <a href="<?= htmlspecialchars($socialLinkedin) ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle"><i class="bi bi-linkedin"></i></a>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="info-banner small mt-4 shadow-sm">
                        <h6>Contact the Office</h6>
                        <ul class="list-unstyled mb-0 mt-3 small">
                            <?php if ($contactEmail): ?>
                            <li class="mb-2"><i class="bi bi-envelope me-2"></i> <?= htmlspecialchars($contactEmail) ?></li>
                            <?php endif; ?>
                            <?php if ($phone): ?>
                            <li class="mb-0"><i class="bi bi-telephone me-2"></i> <?= htmlspecialchars($phone) ?></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="content-card shadow-sm">
                        <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill mb-3">MCE's Profile</span>
                        <h2 class="fw-bold mb-4">Hon. <?= htmlspecialchars($fullName) ?></h2>
                        <div class="profile-content text-muted" style="line-height: 1.8;">
                            
                            <!-- Early Life and Education -->
                            <?php if (!empty($mce['early_life'])): ?>
                            <h4 class="mt-4 text-dark fw-bold"><i class="bi bi-book me-2 text-primary"></i> Early Life and Education</h4>
                            <?= nl2br(htmlspecialchars($mce['early_life'])) ?>
                            <?php endif; ?>
                            
                            <!-- Professional and Political Career -->
                            <?php if (!empty($mce['career'])): ?>
                            <h4 class="mt-5 text-dark fw-bold"><i class="bi bi-briefcase me-2 text-primary"></i> Professional and Political Career</h4>
                            <?= nl2br(htmlspecialchars($mce['career'])) ?>
                            <?php endif; ?>
                            
                            <!-- Personal Life -->
                            <?php if (!empty($mce['personal_life'])): ?>
                            <h4 class="mt-5 text-dark fw-bold"><i class="bi bi-heart me-2 text-primary"></i> Personal Life</h4>
                            <?= nl2br(htmlspecialchars($mce['personal_life'])) ?>
                            <?php endif; ?>
                            
                            <!-- Education & Background (legacy) -->
                            <?php if ($education && empty($mce['early_life'])): ?>
                            <h4 class="mt-5 text-dark fw-bold"><i class="bi bi-mortarboard me-2 text-primary"></i> Education & Background</h4>
                            <?= nl2br(htmlspecialchars($education)) ?>
                            <?php endif; ?>
                            
                            <!-- Biography (legacy fallback) -->
                            <?php if ($biography && empty($mce['career'])): ?>
                            <h4 class="mt-5 text-dark fw-bold"><i class="bi bi-file-text me-2 text-primary"></i> Biography</h4>
                            <?= nl2br(htmlspecialchars($biography)) ?>
                            <?php endif; ?>
                            
                            <?php if (!$biography && !$education && empty($mce['early_life']) && empty($mce['career'])): ?>
                            <p>Hon. <?= htmlspecialchars($fullName) ?> is dedicated to the progress and development of the New Juaben South Municipality. Under his leadership, the Assembly focuses on transparency, community engagement, and sustainable infrastructure.</p>
                            <?php endif; ?>
                            
                            <!-- Vision for NJSMA -->
                            <?php if ($vision): ?>
                            <h4 class="mt-5 text-dark fw-bold"><i class="bi bi-eye me-2 text-primary"></i> Vision for NJSMA</h4>
                            <div class="bg-light p-4 rounded-3 border-start border-4 border-primary">
                                <p class="mb-0 italic">"<?= nl2br(htmlspecialchars($vision)) ?>"</p>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Legacy and Vision -->
                            <?php if (!empty($mce['legacy'])): ?>
                            <h4 class="mt-5 text-dark fw-bold"><i class="bi bi-award me-2 text-primary"></i> Legacy and Vision</h4>
                            <?= nl2br(htmlspecialchars($mce['legacy'])) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>