<?php include PATH_ROOT . '/views/admin/layouts/header.php'; ?>

<div class="page-header d-print-none mb-3">
  <div class="row align-items-center">
    <div class="col">
      <h2 class="page-title"><?= htmlspecialchars($pageTitle) ?></h2>
      <div class="text-muted mt-1">Xem chi tiết câu hỏi & phản hồi người dùng</div>
    </div>
    <div class="col-auto ms-auto">
      <a href="<?= BASE_URL; ?>/cms/faq/user" class="btn btn-secondary">
        <i class="ti ti-arrow-left"></i> Quay lại
      </a>
    </div>
  </div>
</div>


<!-- QUESTION INFO -->
<div class="card mb-4">
  <div class="card-body">
    <h4 class="text-primary mb-3"><i class="ti ti-help"></i> Câu hỏi</h4>
    <p class="text-dark"><?= nl2br(htmlspecialchars($question['question'])) ?></p>

    <div class="mt-3 d-flex flex-wrap gap-2">
      <span class="badge bg-primary">
        <i class="ti ti-user"></i>
        <?= htmlspecialchars($question['full_name'] ?? "User #{$question['user_id']}") ?>
      </span>

      <?php if (!empty($question['category_name'])): ?>
        <span class="badge"
          style="background-color: <?= htmlspecialchars($question['category_color'] ?? '#0dcaf0'); ?>; color: #000;">
          <i class="ti ti-tag"></i>
          <?= htmlspecialchars($question['category_name']) ?>
        </span>
      <?php endif; ?>

      <span class="badge bg-secondary">
        <i class="ti ti-calendar"></i>
        <?= date("d/m/Y H:i", strtotime($question['created_at'])) ?>
      </span>
    </div>
  </div>
</div>


<!-- UPDATE QUESTION STATUS -->
<div class="card mb-4">
  <div class="card-body">
    <h4 class="text-warning mb-3"><i class="ti ti-flag"></i> Trạng thái câu hỏi</h4>

    <form method="POST" action="<?= BASE_URL ?>/cms/faq/user/status/<?= $question['id'] ?>"
      class="row g-3 align-items-center">
      <div class="col-md-4">
        <select name="status" class="form-select">
          <option value="pending" <?= $question['status'] === 'pending' ? 'selected' : '' ?>>Chờ trả lời</option>
          <option value="answered" <?= $question['status'] === 'answered' ? 'selected' : '' ?>>Đã trả lời</option>
          <option value="closed" <?= $question['status'] === 'closed' ? 'selected' : '' ?>>Đã đóng</option>
        </select>
      </div>

      <div class="col-md-2">
        <button class="btn btn-warning w-100">
          <i class="ti ti-edit"></i> Cập nhật
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ADMIN REPLY FORM -->
<div class="card mb-4">
  <div class="card-body">
    <h4 class="text-success mb-3"><i class="ti ti-reply"></i> Trả lời người dùng</h4>

    <form method="POST" action="<?= BASE_URL ?>/cms/faq/user/detail/<?= $question['id'] ?>">
      <textarea name="content" class="form-control mb-3" placeholder="Nhập nội dung trả lời..." rows="3"
        required></textarea>

      <div class="d-flex gap-2">
        <button class="btn btn-success">
          <i class="ti ti-send"></i> Gửi trả lời
        </button>

        <a href="<?= BASE_URL ?>/cms/faq/user" class="btn btn-secondary">
          <i class="ti ti-arrow-left"></i> Quay lại
        </a>
      </div>
    </form>
  </div>
</div>

<!-- LIST COMMENTS -->
<div class="card mb-4">
  <div class="card-body">
    <h4 class="text-primary mb-3">
      <i class="ti ti-message"></i> Bình luận
    </h4>

    <?php if (empty($comments)): ?>
      <p class="text-muted mb-0">Chưa có bình luận nào.</p>
    <?php else: ?>
      <?php foreach ($comments as $c): ?>
        <div class="mb-3 border-bottom pb-2">
          <div class="fw-bold <?= $c['is_admin'] ? 'text-success' : 'text-info' ?>">
            <i class="<?= $c['is_admin'] ? 'ti ti-shield' : 'ti ti-user' ?>"></i>
            <?= htmlspecialchars($c['full_name'] ?? "User #{$c['user_id']}") ?>
          </div>

          <div class="mt-1 mb-1 text-dark">
            <?= nl2br(htmlspecialchars($c['content'])) ?>
          </div>

          <div class="text-muted small">
            <i class="ti ti-clock"></i>
            <?= date("d/m/Y H:i", strtotime($c['created_at'])) ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

<?php include PATH_ROOT . '/views/admin/layouts/footer.php'; ?>