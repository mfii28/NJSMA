
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
                <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
            </ul>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Building & Construction Permit</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">
Business Operating Permit</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Waste management</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Water & Sanitation</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">
Social Sevices</a></li>
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

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>NJSMA</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
           Designed by <a href="#">ManuelKophie</a>
      </div>
    </div>
  </footer><!-- End Footer -->




<div id="preloader"></div>



  <!-- Vendor JS Files -->
  <script src="./lib/vendor/jquery/js/jquery.bundle.min.js"></script>
  <script src="./lib/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="./lib/vendor/aos/aos.js"></script>
  <script src="./lib/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="./lib/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="./lib/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="./lib/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->

<script src="./lib/main.js"></script>
<script>

   /**
   * Porfolio isotope and filter
   */
  let portfolionIsotope = document.querySelector('.portfolio-isotope');

  if (portfolionIsotope) {

    let portfolioFilter = portfolionIsotope.getAttribute('data-portfolio-filter') ? portfolionIsotope.getAttribute('data-portfolio-filter') : '*';
    let portfolioLayout = portfolionIsotope.getAttribute('data-portfolio-layout') ? portfolionIsotope.getAttribute('data-portfolio-layout') : 'masonry';
    let portfolioSort = portfolionIsotope.getAttribute('data-portfolio-sort') ? portfolionIsotope.getAttribute('data-portfolio-sort') : 'original-order';

    window.addEventListener('load', () => {
      let portfolioIsotope = new Isotope(document.querySelector('.portfolio-container'), {
        itemSelector: '.portfolio-item',
        layoutMode: portfolioLayout,
        filter: portfolioFilter,
        sortBy: portfolioSort
      });

      let menuFilters = document.querySelectorAll('.portfolio-isotope .portfolio-flters li');
      menuFilters.forEach(function(el) {
        el.addEventListener('click', function() {
          document.querySelector('.portfolio-isotope .portfolio-flters .filter-active').classList.remove('filter-active');
          this.classList.add('filter-active');
          portfolioIsotope.arrange({
            filter: this.getAttribute('data-filter')
          });
          if (typeof aos_init === 'function') {
            aos_init();
          }
        }, false);
      });

    });

  }

  
 /**
   * Animation on scroll
   */
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