<?php include PATH_ROOT . '/views/admin/layouts/header.php'; ?>

<div class="page-header d-print-none">
  <div class="row g-2 align-items-center">
    <div class="col">
      <h2 class="page-title"><?php echo $pageTitle; ?></h2>
    </div>
    <div class="col-auto ms-auto">
      <a href="<?php echo BASE_URL; ?>/cms/faq/category" class="btn btn-secondary">
        <i class="ti ti-arrow-left"></i> Quay lại
      </a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <form method="POST" action="<?php echo BASE_URL; ?>/cms/faq/category/add">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Thông tin thể loại</h3>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label required">Tên thể loại</label>
            <input type="text" class="form-control" name="name" required>
          </div>

          <!-- Màu hiển thị -->
          <div class="mb-3">
            <label class="form-label required">Màu hiển thị</label>
            <div class="d-flex align-items-center gap-2">
              <input type="color" class="form-control form-control-color" name="color" id="faq-color-input"
                value="#3498db" required title="Chọn màu cho thể loại">
              <span class="text-muted small">
                Mã hex: <code id="faq-color-hex">#3498db</code>
              </span>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-check">
              <input type="checkbox" class="form-check-input" name="is_active" value="1" checked>
              <span class="form-check-label">Hiển thị</span>
            </label>
          </div>
        </div>
        <div class="card-footer text-end">
          <a href="<?php echo BASE_URL; ?>/cms/faq/category" class="btn btn-link">Hủy</a>
          <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy"></i> Lưu thể loại
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  (function () {
    var input = document.getElementById('faq-color-input');
    var label = document.getElementById('faq-color-hex');
    if (input && label) {
      input.addEventListener('input', function () {
        label.textContent = input.value;
      });
    }
  })();
</script>

<?php include PATH_ROOT . '/views/admin/layouts/footer.php'; ?>