</main>

<footer class="footer bg-dark text-white pt-5 pb-4 mt-5">
  <div class="container">
    <div class="row gy-4">
      <div class="col-md-4">
        <h3 class="fw-bold text-primary mb-3">
          <i class="bi bi-cube me-2"></i> BK Figure Lab
        </h3>
        <p class="text-white-50">
          Nơi hội tụ đam mê mô hình – nơi cảm hứng trở thành hiện thực.
          Chuyên cung cấp mô hình figure, xe hơi, anime chất lượng cao.
        </p>
        <div class="social-links mt-3">
          <a href="https://facebook.com" class="text-white me-3" target="_blank">
            <i class="bi bi-facebook" style="font-size: 24px;"></i>
          </a>
          <a href="https://instagram.com" class="text-white me-3" target="_blank">
            <i class="bi bi-instagram" style="font-size: 24px;"></i>
          </a>
          <a href="https://github.com" class="text-white me-3" target="_blank">
            <i class="bi bi-github" style="font-size: 24px;"></i>
          </a>
          <a href="mailto:contact@bkfigurelab.com" class="text-white me-3" target="_blank">
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
          <li class="mb-2"><i class="bi bi-geo-alt-fill text-primary me-2"></i> 268 Lý Thường Kiệt, Q.10, TP.HCM</li>
          <li class="mb-2"><i class="bi bi-telephone-fill text-primary me-2"></i> 0909 123 456</li>
          <li class="mb-2"><i class="bi bi-envelope-fill text-primary me-2"></i> contact@bkfigurelab.com</li>
          <li class="mb-2"><i class="bi bi-clock-fill text-primary me-2"></i> Thứ 2 – CN: 8:00 – 21:00</li>
        </ul>
      </div>
    </div>

    <hr class="border-secondary my-4">

    <div class="text-center">
      <p class="mb-0 text-white-50">
        © <?= date('Y') ?> BK Figure Lab. All rights reserved.
        <i class="bi bi-heart-fill text-danger mx-1"></i> Made with passion for collectors.
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