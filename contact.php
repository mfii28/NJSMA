<?php 
require_once __DIR__ . '/src/init.php';

$pageTitle = "Contact Us | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';
?>

<main id="main">
    <section class="page-header text-center">
        <div class="container">
            <h1>Contact Us</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="<?= SITE_URL ?>" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Contact</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="contact-section pb-5">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-4">
                    <div class="sidebar-nav shadow-sm mb-4">
                        <h4>General Inquiries</h4>
                        <div class="mt-3">
                            <div class="d-flex mb-3">
                                <div class="icon-box me-3 text-primary"><i class="bi bi-geo-alt fs-4"></i></div>
                                <div>
                                    <h6 class="fw-bold mb-1">Office Location</h6>
                                    <p class="small text-muted mb-0">EN-010-4770, Koforidua, Eastern Region</p>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="icon-box me-3 text-primary"><i class="bi bi-telephone fs-4"></i></div>
                                <div>
                                    <h6 class="fw-bold mb-1">Phone Number</h6>
                                    <p class="small text-muted mb-0">+233 34 229 3669</p>
                                </div>
                            </div>
                            <div class="d-flex mb-0">
                                <div class="icon-box me-3 text-primary"><i class="bi bi-envelope fs-4"></i></div>
                                <div>
                                    <h6 class="fw-bold mb-1">Email Address</h6>
                                    <p class="small text-muted mb-0">info@njsma.gov.gh</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="info-banner shadow-sm">
                        <h5 class="fw-bold"><i class="bi bi-clock-history me-2"></i> Working Hours</h5>
                        <ul class="list-unstyled small mt-3 mb-0">
                            <li class="d-flex justify-content-between mb-2"><span>Mon - Fri:</span> <span>8:00 AM - 5:00 PM</span></li>
                            <li class="d-flex justify-content-between"><span>Sat - Sun:</span> <span class="badge bg-danger">Closed</span></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="content-card shadow-sm">
                        <h3 class="fw-bold mb-4">Send us a Message</h3>
                        <form action="" method="post" class="contact-form">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold">Full Name</label>
                                    <input type="text" class="form-control" placeholder="Enter your name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold">Email Address</label>
                                    <input type="email" class="form-control" placeholder="Enter your email" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Subject</label>
                                <input type="text" class="form-control" placeholder="What is this about?" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold">Your Message</label>
                                <textarea class="form-control" rows="5" placeholder="How can we help you?" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill fw-bold">Send Message <i class="bi bi-send ms-2"></i></button>
                        </form>
                    </div>

                    <div class="mt-4 rounded-4 overflow-hidden shadow-sm" style="height: 300px;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15858.987654321098!2d-0.260000!3d6.100000!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMDYnMDAuMCJOIDDCsDE1JzM2LjAiVw!5e0!3m2!1sen!2sgh!4v1234567890123" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>