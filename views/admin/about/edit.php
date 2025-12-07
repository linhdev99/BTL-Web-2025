<?php
$aboutData = $data['aboutData'] ?? [];
?>

<div class="container py-4">
  <h1 class="text-center text-primary mb-4"><?= htmlspecialchars($pageTitle) ?></h1>

  <?php if (!empty($_GET['status']) && $_GET['status'] === 'success'): ?>
    <div class="alert alert-success">Cập nhật thành công!</div>
  <?php endif; ?>

  <form action="/cms/about/edit/update" method="post">
    <div class="card mb-4 shadow-sm">
      <div class="card-header fw-bold bg-primary text-white">Thông tin chung</div>
      <div class="card-body">
        <div class="mb-3">
          <label class="form-label">Tiêu đề chính (title1)</label>
          <input type="text" name="title1" value="<?= htmlspecialchars($aboutData['title1'] ?? '') ?>"
            class="form-control">
        </div>
        <div class="mb-3">
          <label class="form-label">Phụ đề nhóm (subtitle1)</label>
          <input type="text" name="subtitle1" value="<?= htmlspecialchars($aboutData['subtitle1'] ?? '') ?>"
            class="form-control">
        </div>
        <div class="mb-3">
          <label class="form-label">Phụ đề “Về chúng tôi” (subtitle2)</label>
          <input type="text" name="subtitle2" value="<?= htmlspecialchars($aboutData['subtitle2'] ?? '') ?>"
            class="form-control">
        </div>
      </div>
    </div>

    <div class="card mb-4 shadow-sm">
      <div class="card-header fw-bold bg-success text-white">Thành viên nhóm</div>
      <div class="card-body">
        <?php for ($i = 1; $i <= 3; $i++): ?>
          <div class="border rounded-3 p-3 mb-3 bg-light">
            <h5 class="fw-bold text-success mb-3">Thành viên <?= $i ?></h5>
            <div class="mb-2">
              <label class="form-label">Họ tên</label>
              <input type="text" name="name<?= $i ?>" value="<?= htmlspecialchars($aboutData["name$i"] ?? '') ?>"
                class="form-control">
            </div>
            <div class="mb-2">
              <label class="form-label">MSSV</label>
              <input type="text" name="mssv<?= $i ?>" value="<?= htmlspecialchars($aboutData["mssv$i"] ?? '') ?>"
                class="form-control">
            </div>
            <div class="mb-2">
              <label class="form-label">Vai trò</label>
              <input type="text" name="mission<?= $i ?>" value="<?= htmlspecialchars($aboutData["mission$i"] ?? '') ?>"
                class="form-control">
            </div>
            <div class="mb-2">
              <label class="form-label">Avatar</label>
              <input type="text" name="avatar<?= $i ?>" value="<?= htmlspecialchars($aboutData["avatar$i"] ?? '') ?>"
                class="form-control">
            </div>
          </div>
        <?php endfor; ?>
      </div>
    </div>

    <div class="card mb-4 shadow-sm">
      <div class="card-header fw-bold bg-info text-white">Nội dung “Về chúng tôi”</div>
      <div class="card-body">
        <textarea id="summernote" name="about" rows="10"
          class="form-control"><?= htmlspecialchars($aboutData['about'] ?? '') ?></textarea>
      </div>
    </div>

    <div class="text-center">
      <button type="submit" class="btn btn-primary px-5">💾 Lưu thay đổi</button>
    </div>
  </form>
</div>

<script>
  $(document).ready(function () {
    $('#summernote').summernote({
      height: 1000,
      placeholder: 'Nhập nội dung “Về chúng tôi” tại đây...',
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['insert', ['link', 'picture']],
        ['view', ['codeview']]
      ]
    });
  });
</script>