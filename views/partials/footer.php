  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-4 col-md-6">
            <div class="footer-info">
              <h3>Contact us</h3>
              <p class="pb-3"><em>New Juaben South Municipal Assembly.</em></p>
              <p>
              EN-010-4770  <br>
              Koforidua <br><br>
                <strong>Phone:</strong> 0342293669 / 0362290131 <br>
                <strong>Email:</strong> info@njsma.gov.gh<br>
              </p>
              <div class="social-links mt-3">
                <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="<?= SITE_URL ?>/">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="<?= SITE_URL ?>/about.php">About us</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="<?= SITE_URL ?>/#services">Services</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
            </ul>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Building Permit</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Business Permit</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Waste Management</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Social Services</a></li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>Our Newsletter</h4>
            <form action="" method="post">
              <input type="email" name="email"><input type="submit" value="Subscribe">
            </form>
          </div>

        </div>
      </div>
    </div>

    <!-- Quick Links Sidebar -->
    <div class="quick-links-sidebar d-none d-md-block">
        <div class="quick-links-btn">
            <i class="bi bi-link-45deg"></i>
            <span>Quick Links</span>
        </div>
        <ul class="quick-links-list">
            <li><a href="<?= SITE_URL ?>/repository.php?cat=Forms"><i class="bi bi-file-earmark-text"></i> Application Forms</a></li>
            <li><a href="<?= SITE_URL ?>/tenders.php"><i class="bi bi-briefcase"></i> Tenders</a></li>
            <li><a href="<?= SITE_URL ?>/about.php#contact"><i class="bi bi-geo-alt"></i> GPS Address</a></li>
            <li><a href="#"><i class="bi bi-credit-card"></i> Pay Online</a></li>
        </ul>
    </div>

    <style>
        .quick-links-sidebar {
            position: fixed;
            right: -150px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 999;
            transition: all 0.3s ease;
        }
        .quick-links-sidebar:hover {
            right: 0;
        }
        .quick-links-btn {
            position: absolute;
            left: -40px;
            background: var(--color-primary, #008374);
            color: white;
            padding: 15px 10px;
            border-radius: 5px 0 0 5px;
            writing-mode: vertical-rl;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .quick-links-list {
            background: white;
            padding: 20px;
            margin: 0;
            list-style: none;
            box-shadow: -5px 0 15px rgba(0,0,0,0.1);
            width: 200px;
        }
        .quick-links-list li {
            margin-bottom: 15px;
        }
        .quick-links-list a {
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }
        .quick-links-list a:hover {
            color: var(--color-primary, #008374);
        }
    </style>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span><?= SITE_NAME ?></span></strong>. All Rights Reserved
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?= SITE_URL ?>/lib/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= SITE_URL ?>/lib/vendor/aos/aos.js"></script>
  <script src="<?= SITE_URL ?>/lib/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="<?= SITE_URL ?>/lib/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="<?= SITE_URL ?>/lib/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="<?= SITE_URL ?>/lib/main.js"></script>

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
