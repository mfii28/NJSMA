<?php
require_once __DIR__ . '/src/init.php';

$pageTitle = "Client Service Charter | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';
?>

<main id="main">
    <section class="breadcrumbs d-flex align-items-center" style="background-image: url('dashboard/assets/img/heroImg/slider-1.jpg'); height: 200px; background-size: cover;">
        <div class="container text-center">
            <h2 class="text-white">Client Service Charter</h2>
        </div>
    </section>

    <section class="service-charter mt-5">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-8">
                    <h3>Purpose of the Charter</h3>
                    <p>This Client Service Charter is a public statement of our commitment to provide quality service to all our clients. It outlines what we do, our service standards, and how you can help us improve.</p>

                    <h3 class="mt-4">Our Service Standards</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Service</th>
                                    <th>Timeline (Turnaround Time)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Building Permit Approval</td>
                                    <td>Within 30 Working Days</td>
                                </tr>
                                <tr>
                                    <td>Business Operating Permit</td>
                                    <td>Within 5 Working Days</td>
                                </tr>
                                <tr>
                                    <td>Birth/Death Registration</td>
                                    <td>Within 2 Working Days</td>
                                </tr>
                                <tr>
                                    <td>Marriage Registration (Notice)</td>
                                    <td>21 Days Notice Period</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3 class="mt-4">Our Responsibilities</h3>
                    <ul>
                        <li>We will provide transparent and accountable local governance.</li>
                        <li>We will treat all clients with respect and courtesy.</li>
                        <li>We will listen to your feedback and use it to improve our services.</li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <div class="p-4 bg-light border rounded">
                        <h4>Contact Complaints Unit</h4>
                        <p>If you are not satisfied with our service, please contact us:</p>
                        <p><strong>Hotline:</strong> 0342293669</p>
                        <p><strong>Email:</strong> complaints@njsma.gov.gh</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>
