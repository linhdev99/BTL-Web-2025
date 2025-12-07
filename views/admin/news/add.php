<div class="page-header d-print-none mb-4">
  <div class="row g-2 align-items-center">
    <div class="col">
      <h2 class="page-title"><?= htmlspecialchars($pageTitle ?? 'Thêm tin tức'); ?></h2>
    </div>
    <div class="col-auto ms-auto">
      <a href="<?= BASE_URL; ?>/cms/news" class="btn btn-secondary">
        <i class="ti ti-arrow-left"></i> Quay lại
      </a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <form method="POST" action="<?= BASE_URL; ?>/cms/news/add">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Thông tin tin tức</h3>
        </div>

        <div class="card-body">
          <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <div class="d-flex">
                <div><i class="ti ti-alert-circle alert-icon me-2"></i></div>
                <div><?= $_SESSION['error'];
                unset($_SESSION['error']); ?></div>
              </div>
              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
          <?php endif; ?>

          <div class="row">
            <!-- CỘT TRÁI -->
            <div class="col-md-8">
              <!-- TIÊU ĐỀ -->
              <div class="mb-3">
                <label class="form-label required">Tiêu đề</label>
                <input type="text" class="form-control" name="title" id="title" required
                  value="<?= isset($_SESSION['old']['title']) ? htmlspecialchars($_SESSION['old']['title']) : ''; ?>">
              </div>

              <!-- TÓM TẮT -->
              <div class="mb-3">
                <label class="form-label">Tóm tắt</label>
                <textarea class="form-control" name="summary"
                  rows="3"><?= isset($_SESSION['old']['summary']) ? htmlspecialchars($_SESSION['old']['summary']) : ''; ?></textarea>
              </div>

              <!-- NỘI DUNG (WYSIWYG) -->
              <div class="mb-3">
                <label class="form-label required">Nội dung</label>
                <textarea id="summernote" name="content"
                  required><?= isset($_SESSION['old']['content']) ? htmlspecialchars($_SESSION['old']['content']) : ''; ?></textarea>
              </div>
            </div>

            <!-- CỘT PHẢI -->
            <div class="col-md-4">
              <!-- ẢNH THUMBNAIL (URL) -->
              <div class="mb-3">
                <label class="form-label">Ảnh thumbnail (URL)</label>
                <input type="url" class="form-control" name="thumbnail" placeholder="https://example.com/image.jpg"
                  value="<?= isset($_SESSION['old']['thumbnail']) ? htmlspecialchars($_SESSION['old']['thumbnail']) : ''; ?>"
                  oninput="previewThumbnail(this.value)">
                <small class="form-hint">Dán URL ảnh để hiển thị thumbnail bài viết</small>

                <div class="mt-2 text-center">
                  <img id="thumbnailPreview"
                    src="<?= !empty($_SESSION['old']['thumbnail']) ? htmlspecialchars($_SESSION['old']['thumbnail']) : 'https://via.placeholder.com/300x180?text=No+Image'; ?>"
                    alt="Preview" class="img-fluid rounded border" style="max-height:180px; object-fit:cover;">
                </div>
              </div>

              <!-- TRẠNG THÁI -->
              <div class="mb-3">
                <label class="form-label required">Trạng thái</label>
                <select class="form-select" name="status" required>
                  <option value="draft" <?= (isset($_SESSION['old']['status']) && $_SESSION['old']['status'] == 'draft') ? 'selected' : ''; ?>>Nháp</option>
                  <option value="published" <?= (isset($_SESSION['old']['status']) && $_SESSION['old']['status'] == 'published') ? 'selected' : 'selected'; ?>>Công khai</option>
                </select>
              </div>

              <!-- NGÀY XUẤT BẢN -->
              <div class="mb-3">
                <label class="form-label">Ngày xuất bản</label>
                <input type="datetime-local" class="form-control" name="published_at"
                  value="<?= isset($_SESSION['old']['published_at']) ? $_SESSION['old']['published_at'] : date('Y-m-d\TH:i'); ?>">
              </div>
            </div>
          </div>
        </div>

        <!-- FOOTER -->
        <div class="card-footer text-end">
          <a href="<?= BASE_URL; ?>/cms/news" class="btn btn-link">Hủy</a>
          <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy"></i> Lưu tin tức
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- SUMMERNOTE -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

<script>
  function previewThumbnail(url) {
    const img = document.getElementById('thumbnailPreview');
    img.src = (url && url.startsWith('http'))
      ? url
      : 'https://via.placeholder.com/300x180?text=No+Image';
  }

  document.addEventListener('DOMContentLoaded', function () {
    $('#summernote').summernote({
      placeholder: 'Nhập nội dung bài viết...',
      height: 400,
      tabsize: 2,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'clear']],
        ['fontname', ['fontname']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']]
      ],
      callbacks: {
        onImageUpload: function () {
          alert("⚠️ Tính năng upload ảnh chưa được bật. Hãy dán URL ảnh vào nội dung.");
        }
      }
    });
  });
</script>

<?php unset($_SESSION['old']); ?>