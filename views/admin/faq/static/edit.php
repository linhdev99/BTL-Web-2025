<?php include PATH_ROOT . '/views/admin/layouts/header.php'; ?>

<div class="page-header d-print-none">
  <div class="row g-2 align-items-center">
    <div class="col">
      <h2 class="page-title"><?= escape($pageTitle); ?></h2>
    </div>
    <div class="col-auto ms-auto">
      <a href="<?= BASE_URL; ?>/cms/faq/static" class="btn btn-secondary">
        <i class="ti ti-arrow-left"></i> Quay lại
      </a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <form method="POST" action="<?= BASE_URL; ?>/cms/faq/static/edit/<?= $faq['id']; ?>">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Chỉnh sửa FAQ</h3>
        </div>

        <div class="card-body">
          <!-- Thể loại -->
          <div class="mb-3">
            <label class="form-label required">Thể loại</label>
            <select class="form-select" name="category_id" required>
              <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id']; ?>" <?= ($cat['id'] == $faq['category_id']) ? 'selected' : ''; ?>>
                  <?= escape($cat['name']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Câu hỏi -->
          <div class="mb-3">
            <label class="form-label required">Câu hỏi</label>
            <textarea id="faqQuestion" class="form-control" name="question" rows="3"
              required><?= htmlspecialchars($faq['question']); ?></textarea>
          </div>

          <!-- Câu trả lời -->
          <div class="mb-3">
            <label class="form-label required">Câu trả lời</label>
            <textarea id="faqAnswer" class="form-control" name="answer" rows="5"
              required><?= htmlspecialchars($faq['answer']); ?></textarea>
          </div>

          <!-- Thứ tự & Trạng thái -->
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Thứ tự hiển thị</label>
                <input type="number" class="form-control" name="ordering" value="<?= $faq['ordering']; ?>">
              </div>
            </div>
            <div class="col-md-6 d-flex align-items-center">
              <label class="form-check m-0">
                <input type="checkbox" class="form-check-input" name="is_active" value="1" <?= $faq['is_active'] ? 'checked' : ''; ?>>
                <span class="form-check-label">Hiển thị</span>
              </label>
            </div>
          </div>
        </div>

        <div class="card-footer text-end">
          <a href="<?= BASE_URL; ?>/cms/faq/static" class="btn btn-link">Hủy</a>
          <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy"></i> Cập nhật FAQ
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Khởi tạo Summernote -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    $('#faqQuestion, #faqAnswer').summernote({
      placeholder: 'Nhập nội dung...',
      tabsize: 2,
      height: 200,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'clear']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']]
      ]
    });
  });
</script>

<style>
  .note-editor.note-frame {
    border: 1px solid #dee2e6;
    border-radius: 8px;
  }

  .note-toolbar {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
  }
</style>

<?php include PATH_ROOT . '/views/admin/layouts/footer.php'; ?>