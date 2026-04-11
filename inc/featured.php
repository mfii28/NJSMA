<?php
$mceInfo = Core\Database::getInstance()->fetch("SELECT * FROM mce LIMIT 1");
?>
<!-- ======= Featured Section (MCE Message) ======= -->
<section id="mce-featured" class="mce-featured py-5">
    <div class="container" data-aos="fade-up">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="mce-img-wrapper">
                    <img src="<?= SITE_URL ?>/dashboard/assets/img/mce.jpg" alt="Hon. <?= $mceInfo['first_name'] ?> <?= $mceInfo['last_name'] ?>" class="img-fluid rounded-4 shadow">
                    <div class="mce-label">
                        <h4>Hon. <?= $mceInfo['first_name'] ?> <?= $mceInfo['last_name'] ?></h4>
                        <p>Municipal Chief Executive</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 ps-lg-5 mt-4 mt-lg-0">
                <div class="mce-message">
                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill mb-3">Welcome Remark</span>
                    <h2 class="fw-bold mb-4">Leading Our Municipality Towards Sustainable Growth</h2>
                    <div class="message-content text-muted">
                        <p>It is my distinct pleasure to welcome you to the official digital portal of the New Juaben South Municipal Assembly. Our commitment is to foster a transparent, accountable, and citizen-centric governance system that brings development to your doorstep.</p>
                        <p>As we navigate the path of transformation, we invite every resident and stakeholder to engage with us, share feedback, and participate in our collective journey to make Koforidua a model of municipal excellence in Ghana.</p>
                    </div>
                    <div class="mt-4">
                        <a href="MCE.php" class="btn btn-success px-4 py-2 me-3">Full Profile</a>
                        <a href="about.php" class="btn btn-outline-secondary px-4 py-2">About NJSMA</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
