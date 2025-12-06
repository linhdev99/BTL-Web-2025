</main>

<!-- Footer -->
<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h3><?= getSiteName() ?></h3>
        <p><?= getSiteTagline() ?></p>
        <div class="social-links mt-3">
          <?php $socialLinks = getSocialLinks(); ?>
          <?php if (!empty($socialLinks['facebook'])): ?>
            <a href="<?= escape($socialLinks['facebook']) ?>" class="text-white me-3" target="_blank"><i
                class="bi bi-facebook" style="font-size: 24px;"></i></a>
          <?php endif; ?>
          <?php if (!empty($socialLinks['instagram'])): ?>
            <a href="<?= escape($socialLinks['instagram']) ?>" class="text-white me-3" target="_blank"><i
                class="bi bi-instagram" style="font-size: 24px;"></i></a>
          <?php endif; ?>
          <?php if (!empty($socialLinks['youtube'])): ?>
            <a href="<?= escape($socialLinks['youtube']) ?>" class="text-white me-3" target="_blank"><i
                class="bi bi-youtube" style="font-size: 24px;"></i></a>
          <?php endif; ?>
          <?php if (!empty($socialLinks['tiktok'])): ?>
            <a href="<?= escape($socialLinks['tiktok']) ?>" class="text-white me-3" target="_blank"><i
                class="bi bi-tiktok" style="font-size: 24px;"></i></a>
          <?php endif; ?>
        </div>
      </div>

      <div class="col-md-4">
        <h3>Liên kết nhanh</h3>
        <ul class="list-unstyled">
          <li><a href="<?php echo BASE_URL; ?>" class="text-white-50">Trang chủ</a></li>
          <li><a href="<?php echo BASE_URL; ?>/about" class="text-white-50">Giới thiệu</a></li>
          <li><a href="<?php echo BASE_URL; ?>/products" class="text-white-50">Sản phẩm</a></li>
          <li><a href="<?php echo BASE_URL; ?>/news" class="text-white-50">Tin tức</a></li>
          <li><a href="<?php echo BASE_URL; ?>/faq" class="text-white-50">Hỏi đáp</a></li>
          <li><a href="<?php echo BASE_URL; ?>/contact" class="text-white-50">Liên hệ</a></li>
        </ul>
      </div>

      <div class="col-md-4">
        <h3>Thông tin liên hệ</h3>
        <ul class="list-unstyled">
          <?php if (getContactAddress()): ?>
            <li class="mb-2">
              <i class="bi bi-geo-alt"></i> <?= getContactAddress() ?>
            </li>
          <?php endif; ?>
          <?php if (getContactPhone()): ?>
            <li class="mb-2">
              <i class="bi bi-telephone"></i> <?= getContactPhone() ?>
            </li>
          <?php endif; ?>
          <?php if (getContactEmail()): ?>
            <li class="mb-2">
              <i class="bi bi-envelope"></i> <?= getContactEmail() ?>
            </li>
          <?php endif; ?>
          <?php if (getWorkingHours()): ?>
            <li class="mb-2">
              <i class="bi bi-clock"></i> <?= nl2br(escape(getWorkingHours())) ?>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>

    <hr class="border-secondary mt-4 mb-3">

    <div class="row">
      <div class="col-md-12 text-center">
        <p class="text-white-50 mb-0">
          <?= getFooterCopyright() ?>
        </p>
      </div>
    </div>
  </div>
</footer>

<?php if (isset($additionalJS)): ?>
  <?php echo $additionalJS; ?>
<?php endif; ?>

<script>
  // Auto dismiss alerts after 5 seconds
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