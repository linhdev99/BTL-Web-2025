</main>

<footer class="footer bg-dark text-white pt-5 pb-4 mt-5">
  <div class="container">
    <div class="row gy-4">
      <div class="col-md-4">
        <?php
        $siteLogo = getSetting('site_logo', '');
        $siteName = getSetting('site_name', 'BK Figure Lab');
        $siteDescription = getSetting('site_description', 'Nơi hội tụ đam mê mô hình – nơi cảm hứng trở thành hiện thực. Chuyên cung cấp mô hình figure, xe hơi, anime chất lượng cao.');
        ?>
        <h3 class="fw-bold text-primary mb-3 d-flex align-items-center">
          <?php if (!empty($siteLogo)): ?>
            <img src="<?php echo escape($siteLogo); ?>" alt="<?php echo escape($siteName); ?>"
                 style="max-height: 35px; margin-right: 10px;">
          <?php else: ?>
            <i class="bi bi-cube me-2"></i>
          <?php endif; ?>
          <?php echo escape($siteName); ?>
        </h3>
        <p class="text-white-50">
          <?php echo escape($siteDescription); ?>
        </p>
        <div class="social-links mt-3">
          <?php
          $socialFacebook = getSetting('social_facebook', '');
          $socialInstagram = getSetting('social_instagram', '');
          $socialTwitter = getSetting('social_twitter', '');
          $socialYoutube = getSetting('social_youtube', '');
          ?>
          <?php if (!empty($socialFacebook)): ?>
            <a href="<?php echo escape($socialFacebook); ?>" class="text-white me-3" target="_blank">
              <i class="bi bi-facebook" style="font-size: 24px;"></i>
            </a>
          <?php endif; ?>
          <?php if (!empty($socialInstagram)): ?>
            <a href="<?php echo escape($socialInstagram); ?>" class="text-white me-3" target="_blank">
              <i class="bi bi-instagram" style="font-size: 24px;"></i>
            </a>
          <?php endif; ?>
          <?php if (!empty($socialTwitter)): ?>
            <a href="<?php echo escape($socialTwitter); ?>" class="text-white me-3" target="_blank">
              <i class="bi bi-twitter" style="font-size: 24px;"></i>
            </a>
          <?php endif; ?>
          <?php if (!empty($socialYoutube)): ?>
            <a href="<?php echo escape($socialYoutube); ?>" class="text-white me-3" target="_blank">
              <i class="bi bi-youtube" style="font-size: 24px;"></i>
            </a>
          <?php endif; ?>
          <a href="mailto:<?php echo escape(getSetting('contact_email', getContactEmail())); ?>" class="text-white me-3" target="_blank">
            <i class="bi bi-envelope" style="font-size: 24px;"></i>
          </a>
        </div>
      </div>

      <div class="col-md-4">
        <h5 class="fw-bold mb-3">Liên kết nhanh</h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo BASE_URL; ?>" class="text-white-50 text-decoration-none d-block mb-2"><i
                class="bi bi-house-door"></i> Trang chủ</a></li>
          <li><a href="<?php echo BASE_URL; ?>/about" class="text-white-50 text-decoration-none d-block mb-2"><i
                class="bi bi-info-circle"></i> Giới thiệu</a></li>
          <li><a href="<?php echo BASE_URL; ?>/products" class="text-white-50 text-decoration-none d-block mb-2"><i
                class="bi bi-box-seam"></i> Sản phẩm</a></li>
          <li><a href="<?php echo BASE_URL; ?>/faq" class="text-white-50 text-decoration-none d-block mb-2"><i
                class="bi bi-question-circle"></i> Hỏi đáp</a></li>
          <li><a href="<?php echo BASE_URL; ?>/contact" class="text-white-50 text-decoration-none d-block mb-2"><i
                class="bi bi-telephone"></i> Liên hệ</a></li>
        </ul>
      </div>

      <div class="col-md-4">
        <h5 class="fw-bold mb-3">Thông tin liên hệ</h5>
        <ul class="list-unstyled text-white-50">
          <?php
          $contactAddress = getSetting('contact_address', '268 Lý Thường Kiệt, Q.10, TP.HCM');
          $contactPhone = getSetting('contact_phone', '0909 123 456');
          $contactEmail = getSetting('contact_email', 'contact@bkfigurelab.com');
          $businessHours = getSetting('business_hours', 'Thứ 2 – CN: 8:00 – 21:00');
          ?>
          <?php if (!empty($contactAddress)): ?>
            <li class="mb-2"><i class="bi bi-geo-alt-fill text-primary me-2"></i> <?php echo escape($contactAddress); ?></li>
          <?php endif; ?>
          <?php if (!empty($contactPhone)): ?>
            <li class="mb-2"><i class="bi bi-telephone-fill text-primary me-2"></i> <?php echo escape($contactPhone); ?></li>
          <?php endif; ?>
          <?php if (!empty($contactEmail)): ?>
            <li class="mb-2"><i class="bi bi-envelope-fill text-primary me-2"></i> <?php echo escape($contactEmail); ?></li>
          <?php endif; ?>
          <?php if (!empty($businessHours)): ?>
            <li class="mb-2"><i class="bi bi-clock-fill text-primary me-2"></i> <?php echo escape($businessHours); ?></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>

    <hr class="border-secondary my-4">

    <div class="text-center">
      <?php
      $footerCopyright = getSetting('footer_copyright', 'BK Figure Lab. All rights reserved.');
      $footerTagline = getSetting('footer_tagline', 'Made with passion for collectors.');
      ?>
      <p class="mb-0 text-white-50">
        © <?= date('Y') ?> <?php echo escape($footerCopyright); ?>
        <?php if (!empty($footerTagline)): ?>
          <i class="bi bi-heart-fill text-danger mx-1"></i> <?php echo escape($footerTagline); ?>
        <?php endif; ?>
      </p>
    </div>
  </div>
</footer>

<?php if (isset($additionalJS)): ?>
  <?php echo $additionalJS; ?>
<?php endif; ?>

<script>
  setTimeout(function () {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function (alert) {
      const bsAlert = new bootstrap.Alert(alert);
      bsAlert.close();
    });
  }, 5000);
</script>

</body>

</html>