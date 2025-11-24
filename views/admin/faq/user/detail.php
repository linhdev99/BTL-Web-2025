<h1 class="text-white mb-4"><?= $page_title ?></h1>

<!-- QUESTION INFO -->
<div class="card bg-dark border-secondary p-4 mb-4">
  <div class="mt-2">
    <div class="faq-category-badge category-<?= (int) ($question['category_id'] ?? 1) ?>">
      <?= $question['category_name'] ?? 'Chưa phân loại' ?>
    </div>
    <div class="faq-status-badge status-<?= $question['status'] ?>">
      <?= match ($question['status']) {
        'active' => 'Hiển thị',
        'pending' => 'Chờ duyệt',
        'hidden' => 'Ẩn',
        default => ucfirst($question['status'])
      } ?>
    </div>
  </div>

  <div class="d-flex align-items-start mb-3">
    <img src="<?= !empty($question['avatar']) ? $question['avatar'] : '/assets/img/default-avatar.png' ?>"
      alt="Avatar người hỏi" class="rounded-circle me-3 border border-secondary" width="56" height="56"
      style="object-fit: cover;" />

    <div class="flex-grow-1">
      <div class="text-white mb-1">
        <i class="fa-regular fa-user me-1"></i>
        <strong><?= htmlspecialchars($question['full_name'] ?? "User #{$question['user_id']}") ?></strong>
        <span class="mx-1">|</span>
        <i class="fa-regular fa-calendar me-1"></i>
        <span><?= date("d/m/Y H:i", strtotime($question['created_at'])) ?></span>
      </div>

      <p class="text-white fs-5 mb-0"><?= nl2br(htmlspecialchars($question['question'])) ?></p>
    </div>
  </div>
</div>

<!-- UPDATE QUESTION STATUS + CATEGORY -->
<div class="card bg-dark border-secondary p-4 mb-4 shadow-sm rounded-3">
  <h4 class="text-warning mb-4">
    <i class="fa-solid fa-flag me-2"></i> Cập nhật thông tin câu hỏi
  </h4>

  <form method="POST" action="/cms/faq/user/update/<?= $question['id'] ?>" class="row g-4 align-items-center">

    <!-- Danh mục -->
    <div class="col-md-5">
      <label for="category_id" class="form-label fw-semibold mb-2 text-light">
        <i class="fa-solid fa-layer-group me-1"></i> Phân loại
      </label>
      <select name="category_id" id="category_id" class="form-select bg-dark text-white border-secondary">
        <?php foreach ($categories as $cat): ?>
          <option value="<?= $cat['id'] ?>" <?= $question['category_id'] == $cat['id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Trạng thái -->
    <div class="col-md-4">
      <label for="status" class="form-label fw-semibold mb-2 text-light">
        <i class="fa-solid fa-toggle-on me-1"></i> Trạng thái
      </label>
      <select name="status" id="status" class="form-select bg-dark text-white border-secondary">
        <option value="pending" <?= $question['status'] === 'pending' ? 'selected' : '' ?>>Chờ duyệt</option>
        <option value="active" <?= $question['status'] === 'active' ? 'selected' : '' ?>>Hiển thị</option>
        <option value="hidden" <?= $question['status'] === 'hidden' ? 'selected' : '' ?>>Ẩn</option>
      </select>
    </div>

    <!-- Nút cập nhật -->
    <div class="col-md-3 d-flex align-items-end">
      <button type="submit" class="btn btn-warning w-100 fw-semibold py-2 shadow-sm">
        <i class="fa-solid fa-pen me-1"></i> Cập nhật
      </button>
    </div>
  </form>
</div>

<!-- LIST COMMENTS -->
<div class="card bg-dark border-secondary p-4 mb-4">
  <h4 class="text-warning mb-3"><?= ICON_COMMENT ?> Bình luận</h4>

  <?php if (empty($comments)): ?>
    <p class="text-white-50">Chưa có bình luận nào.</p>
  <?php else: ?>
    <?php foreach ($comments as $cmt): ?>
      <div class="d-flex align-items-start border-bottom border-secondary pb-3 mb-3">
        <!-- Avatar -->
        <img src="<?= !empty($cmt['avatar']) ? $cmt['avatar'] : '/assets/img/default-avatar.png' ?>" alt="Avatar bình luận"
          class="rounded-circle me-3 border border-secondary" width="48" height="48" style="object-fit: cover;" />

        <!-- Nội dung bình luận -->
        <div class="flex-grow-1">
          <div class="text-white mb-1">
            <i class="fa-regular fa-user me-1"></i>
            <strong><?= htmlspecialchars($cmt['full_name'] ?? "User #{$cmt['user_id']}") ?></strong>
            <span class="mx-1">|</span>
            <i class="fa-regular fa-calendar me-1"></i>
            <span><?= date("d/m/Y H:i", strtotime($cmt['created_at'])) ?></span>
          </div>

          <div class="text-white mb-2">
            <?= nl2br(htmlspecialchars($cmt['content'])) ?>
          </div>

          <!-- Delete Button -->
          <form method="POST" action="/cms/faq/user/detail/<?= $question['id'] ?>/comment/delete/<?= $cmt['id'] ?>"
            onsubmit="return confirm('Xóa bình luận này?')" class="mt-1">
            <button class="btn btn-sm btn-outline-danger">
              <i class="fa-solid fa-trash"></i> Xóa
            </button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<!-- ADMIN REPLY FORM -->
<div class="card bg-dark border-secondary p-4">
  <h4 class="text-success mb-3"><i class="fa-solid fa-reply"></i> Trả lời người dùng</h4>

  <form method="POST" action="/cms/faq/user/detail/<?= $question['id'] ?>">
    <textarea name="content" class="form-control bg-dark text-white mb-3" placeholder="Nhập nội dung trả lời..."
      rows="3" required></textarea>

    <button class="btn btn-success">
      <i class="fa-solid fa-paper-plane"></i> Gửi trả lời
    </button>

    <a href="/cms/faq/user" class="btn btn-secondary">
      <?= ICON_BACK ?> Quay lại
    </a>
  </form>
</div>