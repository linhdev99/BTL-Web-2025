<?php
/**
 * @var array $question
 * @var array $comments
 */
?>

<section class="section py-5">
  <div class="container">
    <!-- Tiêu đề trang -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="fw-bold text-primary mb-0">
        <i class="fa-solid fa-circle-question me-2"></i> Câu hỏi từ cộng đồng
      </h2>
      <a href="<?= BASE_URL ?>/questions" class="btn btn-outline-primary btn-sm">
        <i class="fa-solid fa-list me-1"></i> Xem danh sách câu hỏi
      </a>
    </div>

    <!-- ===== CÂU HỎI CHÍNH ===== -->
    <div class="card shadow-sm mb-4 p-4 question-card">
      <div class="d-flex align-items-start mb-3">
        <img src="<?= !empty($question['avatar'])
          ? BASE_URL . '/' . htmlspecialchars($question['avatar'])
          : 'https://i.pravatar.cc/100?u=' . urlencode($question['full_name'] ?? 'user') ?>" alt="Avatar"
          class="rounded-circle me-3 question-avatar">

        <div class="flex-grow-1">
          <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
            <strong><?= htmlspecialchars($question['full_name'] ?? 'Ẩn danh') ?></strong>
            <span class="text-muted small">
              <i class="fa-regular fa-calendar"></i>
              <?= date("d/m/Y H:i", strtotime($question['created_at'])) ?>
            </span>
            <span class="badge category-badge"
              style="background-color: <?= htmlspecialchars($question['category_color'] ?? '#6c757d') ?>;">
              <?= htmlspecialchars($question['category_name'] ?? 'Chưa phân loại') ?>
            </span>
            <span
              class="badge bg-<?= $question['status'] === 'answered' ? 'success' : ($question['status'] === 'pending' ? 'warning' : 'secondary') ?>">
              <?= $question['status'] === 'answered' ? 'Đã trả lời' : ($question['status'] === 'pending' ? 'Chờ duyệt' : 'Ẩn') ?>
            </span>
          </div>

          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h4 class="fw-bold text-dark mb-2"><?= htmlspecialchars($question['question']) ?></h4>
              <p class="text-muted mb-3">
                <?= nl2br(htmlspecialchars($question['answer'] ?? 'Chưa có câu trả lời.')) ?>
              </p>
            </div>

            <?php if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $question['user_id']): ?>
              <div class="ms-3">
                <a href="<?= BASE_URL ?>/questions/<?= htmlspecialchars($question['id']) ?>/edit"
                  class="btn btn-outline-warning btn-sm" title="Chỉnh sửa câu hỏi">
                  <i class="fa-solid fa-pen-to-square"></i> Sửa
                </a>
              </div>
            <?php endif; ?>
          </div>

          <div class="question-stats text-muted small">
            <span class="me-3"><i class="fa-regular fa-eye"></i> <?= (int) ($question['views'] ?? 0) ?> lượt
              xem</span>
            <span><i class="fa-regular fa-comment-dots"></i> <?= count($comments) ?> bình luận</span>
          </div>
        </div>
      </div>
    </div>

    <!-- ===== DANH SÁCH BÌNH LUẬN ===== -->
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-light fw-semibold">
        <i class="fa-regular fa-comments me-2"></i> Bình luận
      </div>
      <div class="card-body">
        <?php if (!empty($comments)): ?>
          <?php foreach ($comments as $c): ?>
            <div class="d-flex align-items-start border-bottom pb-3 mb-3 fade-in">
              <img src="<?= !empty($c['avatar'])
                ? BASE_URL . '/' . htmlspecialchars($c['avatar'])
                : 'https://i.pravatar.cc/80?u=' . urlencode($c['full_name'] ?? 'guest') ?>" alt="Avatar"
                class="rounded-circle me-3 comment-avatar">
              <div>
                <div class="fw-semibold text-dark"><?= htmlspecialchars($c['full_name'] ?? 'Người dùng ẩn') ?></div>
                <div class="text-muted small mb-1">
                  <i class="fa-regular fa-clock me-1"></i>
                  <?= date("d/m/Y H:i", strtotime($c['created_at'])) ?>
                </div>
                <div class="text-dark"><?= nl2br(htmlspecialchars($c['content'])) ?></div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-muted fst-italic mb-0">💭 Chưa có bình luận nào. Hãy là người đầu tiên!</p>
        <?php endif; ?>
      </div>
    </div>

    <!-- ===== FORM THÊM BÌNH LUẬN ===== -->
    <div class="card shadow-sm">
      <div class="card-header bg-light fw-semibold">
        <i class="fa-regular fa-comment-dots me-2"></i> Viết bình luận của bạn
      </div>
      <div class="card-body">
        <form method="POST" action="/questions/<?= (int) $question['id'] ?>/comment"
          class="d-flex align-items-start gap-3">
          <img src="<?= !empty($_SESSION['user']['avatar'])
            ? BASE_URL . '/' . htmlspecialchars($_SESSION['user']['avatar'])
            : 'https://i.pravatar.cc/80?u=' . urlencode($_SESSION['user']['full_name'] ?? 'guest') ?>" alt="Avatar"
            class="rounded-circle comment-avatar">
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
</section>

<style>
  .section {
    background-color: #f8f9fa;
    min-height: 100vh;
    animation: fadeIn 0.8s ease;
  }

  .question-card {
    border-radius: 16px;
    transition: all 0.3s ease;
  }

  .question-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
  }

  .question-avatar {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border: 2px solid #dee2e6;
  }

  .comment-avatar {
    width: 45px;
    height: 45px;
    object-fit: cover;
    border: 1px solid #dee2e6;
  }

  .category-badge {
    font-size: 0.85rem;
    color: #fff;
    border-radius: 10px;
    padding: 4px 10px;
  }

  .question-stats {
    font-size: 0.9rem;
  }

  .fade-in {
    animation: fadeInUp 0.5s ease forwards;
  }

  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(6px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .btn-outline-warning {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.25s ease;
  }

  .btn-outline-warning:hover {
    background-color: #ffc107;
    color: #fff;
    transform: translateY(-1px);
  }
</style>