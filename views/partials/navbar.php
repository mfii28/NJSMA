<!-- ======= Header ======= -->
<section id="topbar" class="topbar d-flex align-items-center">
    <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
            <i class="bi bi-geo-alt d-flex align-items-center"><span> <?= htmlspecialchars($GLOBAL_SETTINGS['contact_address'] ?? 'GA-000-0000 | Koforidua, GH') ?></span></i>
            <i class="bi bi-envelope d-flex align-items-center ms-4"><a href="mailto:<?= htmlspecialchars($GLOBAL_SETTINGS['contact_email'] ?? 'info@njsma.gov.gh') ?>"> <?= htmlspecialchars($GLOBAL_SETTINGS['contact_email'] ?? 'info@njsma.gov.gh') ?></a></i>
            <div class="quick-links d-none d-lg-flex ms-4">
                <a href="<?= SITE_URL ?>/repository?cat=Bye-Laws" class="ms-2">Bye-Laws</a> |
                <a href="<?= SITE_URL ?>/blogs" class="ms-2">News</a> |
                <a href="<?= SITE_URL ?>/contact" class="ms-2">Contact</a>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <div class="social-links d-none d-md-flex align-items-center">
                <a href="<?= htmlspecialchars($GLOBAL_SETTINGS['twitter_link'] ?? '#') ?>" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="<?= htmlspecialchars($GLOBAL_SETTINGS['facebook_link'] ?? '#') ?>" class="facebook"><i class="bi bi-facebook"></i></a>
            </div>
            <a href="https://customer.gov-gh.com" class="pay-now-btn">Pay for Fees</a>
        </div>
    </div>
</section>

<header id="header" class="header d-flex align-items-center">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
        <a href="<?= SITE_URL ?>/" class="logo d-flex align-items-center">
            <img src="/njsma/dashboard/assets/img/logo-1.png" alt="NJSMA Logo">
            <h1>NJSMA<span>.</span></h1>
        </a>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a href="<?= SITE_URL ?>/">Home</a></li>
                <li class="dropdown"><a href="#"><span>The Assembly</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                    <ul>
                        <li><a href="<?= SITE_URL ?>/assemblyInfo">About NJSMA</a></li>
                        <li><a href="<?= SITE_URL ?>/MCE">The MCE</a></li>
                        <li><a href="<?= SITE_URL ?>/management">Management Team</a></li>
                        <li><a href="<?= SITE_URL ?>/assembly-members">Assembly Members</a></li>
                        <li><a href="<?= SITE_URL ?>/Histroy">Our History</a></li>
                        <li><a href="<?= SITE_URL ?>/service-charter">Service Charter</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a href="<?= SITE_URL ?>/deptInfo"><span>Departments</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                    <ul>
                        <?php 
                        $navDepts = (new \Models\Department())->getAll();
                        foreach(array_slice($navDepts, 0, 6) as $nd): 
                        ?>
                            <li><a href="<?= SITE_URL ?>/department-details?id=<?= $nd['id'] ?>"><?= htmlspecialchars($nd['DeptName']) ?></a></li>
                        <?php endforeach; ?>
                        <li><a href="<?= SITE_URL ?>/deptInfo"><b>View All Departments</b></a></li>
                    </ul>
                </li>
                <li><a href="<?= SITE_URL ?>/service-charter">Services</a></li>
                <li><a href="<?= SITE_URL ?>/tenders">Projects & Tenders</a></li>
                <li class="dropdown"><a href="#"><span>Media Center</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                    <ul>
                        <li><a href="<?= SITE_URL ?>/blogs">Latest News</a></li>
                        <li><a href="<?= SITE_URL ?>/gallery">Photo Gallery</a></li>
                        <li><a href="<?= SITE_URL ?>/repository">Documents Centre</a></li>
                    </ul>
                </li>
                <li><a href="<?= SITE_URL ?>/contact">Contact</a></li>
            </ul>
        </nav>
        <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
        <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
    </div>
</header>
