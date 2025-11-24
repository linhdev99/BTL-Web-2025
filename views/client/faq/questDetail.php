<?php
/**
 * @var array $question
 * @var array $comments
 */
?>

<div class="container my-5">
  <!-- Tiêu đề trang -->
  <div class="page-title">
    <span><i class="fa-solid fa-circle-question"></i>Hỏi đáp</span>
    <a href="/faq/questions" class="btn-view-all">
      <i class="fa-solid fa-list"></i> Xem nhiều câu hỏi
    </a>
  </div>

  <!-- ===== CÂU HỎI CHÍNH ===== -->
  <div class="card shadow-sm mb-4 p-3 " style="display: flex; flex-direction: column; gap: 10px;">
    <!-- Category & Status -->
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
        alt="Avatar" class="rounded-circle me-3" width="60" height="60" style="object-fit: cover;" />
      <div style="display: flex; flex-direction: column; gap: 10px;">
        <div class="small text-muted">
          <i class="fa-regular fa-user me-1"></i>
          <strong><?= $question['full_name'] ?? 'Ẩn danh' ?></strong> |
          <i class="fa-regular fa-calendar me-1"></i>
          <?= date("d/m/Y H:i", strtotime($question['created_at'])) ?>
        </div>
        <h5 class="card-title mb-1 text-dark">
          <?= htmlspecialchars($question['question']) ?>
        </h5>
      </div>
    </div>
  </div>

  <!-- ===== DANH SÁCH BÌNH LUẬN ===== -->
  <div class="card shadow-sm mb-4">
    <div class="card-header bg-light">
      <i class="fa-regular fa-comments me-2"></i> Bình luận
    </div>
    <div class="card-body">
      <?php if (!empty($comments)): ?>
        <?php foreach ($comments as $c): ?>
          <div class="d-flex align-items-start border-bottom pb-3 mb-3">
            <img src="<?= !empty($c['avatar']) ? $c['avatar'] : '/assets/img/default-avatar.png' ?>" alt="Avatar"
              class="rounded-circle me-3" width="45" height="45" style="object-fit: cover;" />
            <div>
              <div class="fw-semibold text-dark">
                <?= $c['full_name'] ?? 'Người dùng #' . $c['user_id'] ?>
              </div>
              <div class="text-muted small mb-2">
                <i class="fa-regular fa-clock me-1"></i>
                <?= date("d/m/Y H:i", strtotime($c['created_at'])) ?>
              </div>
              <div class="text-dark"><?= nl2br(htmlspecialchars($c['content'])) ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-muted fst-italic mb-0">Chưa có bình luận nào.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- ===== FORM THÊM BÌNH LUẬN ===== -->
  <div class="card shadow-sm">
    <div class="card-header bg-light">
      <i class="fa-regular fa-comment-dots me-2"></i> Viết bình luận của bạn
    </div>
    <div class="card-body">
      <form method="POST" action="/faq/comment/add/<?= $question['id'] ?>" class="d-flex align-items-start gap-3">
        <img src="<?= $_SESSION['user']['avatar'] ?? '/assets/img/default-avatar.png' ?>" alt="Avatar"
          class="rounded-circle" width="45" height="45" style="object-fit: cover;" />
        <div class="flex-grow-1">
          <textarea name="content" class="form-control mb-2" rows="3" placeholder="Nhập nội dung bình luận..."
            required></textarea>
          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
              <i class="fa-solid fa-paper-plane me-1"></i> Gửi bình luận
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>