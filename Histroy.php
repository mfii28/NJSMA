<?php 
require_once __DIR__ . '/src/init.php';

$pageTitle = "Our History | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';
?>

<main id="main">
    <section class="page-header text-center">
        <div class="container">
            <h1>Our History</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="<?= SITE_URL ?>" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Our History</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="history-content pb-5">
        <div class="container" data-aos="fade-up">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="content-card shadow-sm">
                        <?php include ROOT_PATH . '/inc/Histroy.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>