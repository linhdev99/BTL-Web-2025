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
    <form method="POST" action="<?= BASE_URL; ?>/cms/faq/static/add">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Thông tin FAQ</h3>
        </div>

        <div class="card-body">
          <!-- Thể loại -->
          <div class="mb-3">
            <label class="form-label required">Thể loại</label>
            <select class="form-select" name="category_id" required>
              <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id']; ?>"><?= escape($cat['name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Giao diện Editor -->
          <div class="mb-3">
            <label class="form-label">Giao diện trình soạn thảo</label>
            <select id="editorTheme" class="form-select w-auto">
              <option value="light" selected>Sáng (mặc định)</option>
              <option value="dark">Tối</option>
              <option value="tabler">Tabler style</option>
            </select>
          </div>

          <!-- Câu hỏi -->
          <div class="mb-3">
            <label class="form-label required">Câu hỏi</label>
            <textarea id="faqQuestion" class="form-control" name="question" rows="3" required></textarea>
          </div>

          <!-- Câu trả lời -->
          <div class="mb-3">
            <label class="form-label required">Câu trả lời</label>
            <textarea id="faqAnswer" class="form-control" name="answer" rows="5" required></textarea>
          </div>

          <!-- Thứ tự & Trạng thái -->
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Thứ tự hiển thị</label>
                <input type="number" class="form-control" name="ordering" value="0">
              </div>
            </div>
            <div class="col-md-6 d-flex align-items-center">
              <label class="form-check m-0">
                <input type="checkbox" class="form-check-input" name="is_active" value="1" checked>
                <span class="form-check-label">Hiển thị</span>
              </label>
            </div>
          </div>
        </div>

        <div class="card-footer text-end">
          <a href="<?= BASE_URL; ?>/cms/faq/static" class="btn btn-link">Hủy</a>
          <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy"></i> Lưu FAQ
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Summernote init + Theme Switch -->
<script> const bootswatchThemes = [
    "default", "cerulean", "cosmo", "cyborg", "darkly", "flatly", "journal",
    "litera", "lumen", "lux", "materia", "minty", "morph", "pulse",
    "quartz", "sandstone", "simplex", "sketchy", "slate", "solar",
    "spacelab", "superhero", "united", "vapor", "yeti", "zephyr"
  ];
  document.addEventListener('DOMContentLoaded', function () {
    const editors = $('#faqQuestion, #faqAnswer');

    // Khởi tạo Summernote
    editors.summernote({
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

    // Hàm đổi theme
    function applyEditorTheme(theme) {
      const frame = document.querySelectorAll('.note-editable');
      frame.forEach(el => {
        el.classList.remove('theme-light', 'theme-dark', 'theme-tabler');
        el.classList.add(`theme-${theme}`);
      });
    }

    // Chọn theme
    document.getElementById('editorTheme').addEventListener('change', function () {
      applyEditorTheme(this.value);
    });

    // Áp dụng theme mặc định
    applyEditorTheme('light');
  });
</script>

<!-- CSS cho từng theme -->
<style>
  .theme-light {
    background: #ffffff;
    color: #000000;
  }

  .theme-dark {
    background: #1e1e1e;
    color: #f1f1f1;
  }

  .theme-tabler {
    background: #f8fafc;
    color: #212529;
  }

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