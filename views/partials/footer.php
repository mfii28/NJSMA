  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-4 col-md-6">
            <div class="footer-info">
              <h3><?= htmlspecialchars($GLOBAL_SETTINGS['site_name'] ?? 'NJSMA') ?></h3>
              <p class="pb-3 text-white-50">Providing excellent municipal services through transparency and citizen participation.</p>
              <p>
                <strong>Digital Address:</strong> <?= htmlspecialchars($GLOBAL_SETTINGS['digital_address'] ?? 'EN-010-4770') ?><br>
                <strong>Location:</strong> <?= htmlspecialchars($GLOBAL_SETTINGS['contact_address'] ?? 'Koforidua, Ghana') ?><br><br>
                <strong>Phone:</strong> <?= htmlspecialchars($GLOBAL_SETTINGS['contact_phone'] ?? '+233 34 229 3669') ?><br>
                <strong>Email:</strong> <?= htmlspecialchars($GLOBAL_SETTINGS['contact_email'] ?? 'info@njsma.gov.gh') ?><br>
              </p>
              <div class="social-links mt-3">
                <a href="<?= htmlspecialchars($GLOBAL_SETTINGS['facebook_link'] ?? '#') ?>" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="<?= htmlspecialchars($GLOBAL_SETTINGS['twitter_link'] ?? '#') ?>" class="twitter"><i class="bi bi-twitter-x"></i></a>
                <a href="<?= htmlspecialchars($GLOBAL_SETTINGS['linkedin_link'] ?? '#') ?>" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Quick Links</h4>
            <ul>
              <li><i class="bi bi-chevron-right"></i> <a href="<?= SITE_URL ?>/">Home</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="<?= SITE_URL ?>/about">About NJSMA</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="<?= SITE_URL ?>/service-charter">Our Services</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="<?= SITE_URL ?>/contact">Contact Us</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Featured Services</h4>
            <ul>
              <li><i class="bi bi-chevron-right"></i> <a href="<?= SITE_URL ?>/repository?cat=Forms">Building Permits</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="<?= SITE_URL ?>/repository?cat=Forms">Business Operating Permits</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="<?= SITE_URL ?>/tenders">Tenders & Projects</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="<?= SITE_URL ?>/repository?cat=Legal">Bye-Laws</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-newsletter">
            <h4>Stay Connected</h4>
            <p>Subscribe to our newsletter for latest updates.</p>
            <form action="" method="post" class="d-flex">
              <input type="email" name="email" class="form-control rounded-0 rounded-start border-0" placeholder="Your Email"><input type="submit" value="Subscribe" class="btn btn-success rounded-0 rounded-end">
            </form>
          </div>

        </div>
      </div>
    </div>

    <!-- Quick Links Sidebar -->
    <div class="quick-links-sidebar d-none d-md-block">
        <div class="quick-links-btn">
            <i class="bi bi-list-task"></i>
            <span>Portal Access</span>
        </div>
        <ul class="quick-links-list">
            <li><a href="<?= SITE_URL ?>/repository?cat=Forms"><i class="bi bi-file-earmark-plus"></i> Application Forms</a></li>
            <li><a href="<?= SITE_URL ?>/repository?cat=Legal"><i class="bi bi-journal-text"></i> Municipal Bye-Laws</a></li>
            <li><a href="<?= SITE_URL ?>/tenders"><i class="bi bi-box-seam"></i> Active Tenders</a></li>
            <li><a href="https://customer.gov-gh.com" target="_blank"><i class="bi bi-credit-card"></i> Pay Fees Online</a></li>
        </ul>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span><?= SITE_NAME ?></span></strong>. All Rights Reserved
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="/njsma/lib/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/njsma/lib/vendor/aos/aos.js"></script>
  <script src="/njsma/lib/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="/njsma/lib/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="/njsma/lib/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="/njsma/lib/main.js"></script>

  <script>
    window.addEventListener('load', () => {
      AOS.init({
        duration: 1000,
        easing: 'ease-in-out',
        once: true,
        mirror: false
      })
    });
  </script>
</body>
</html>
