</div>
</div>

<footer class="footer footer-transparent d-print-none">
  <div class="container-xl">
    <div class="row text-center align-items-center flex-row-reverse">
      <div class="col-12 col-lg-auto mt-3 mt-lg-0">
        <ul class="list-inline list-inline-dots mb-0">
          <li class="list-inline-item">
            <?= getFooterCopyright() ?>
            <a href="<?php echo BASE_URL; ?>" class="link-secondary" target="_blank">
              <i class="ti ti-external-link ms-1"></i> Xem website
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</footer>
</div>
</div>

<?php if (isset($additionalJS)): ?>
  <?php echo $additionalJS; ?>
<?php endif; ?>

<script>
  // Auto dismiss alerts after 5 seconds
  setTimeout(function () {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function (alert) {
      if (alert.classList.contains('alert-dismissible')) {
        const closeButton = alert.querySelector('.btn-close');
        if (closeButton) {
          closeButton.click();
        }
      }
    });
  }, 5000);

  // Confirm delete
  document.querySelectorAll('.delete-confirm').forEach(function (element) {
    element.addEventListener('click', function (e) {
      if (!confirm('Bạn có chắc chắn muốn xóa?')) {
        e.preventDefault();
        return false;
      }
    });
  });
</script>
</body>

</html>