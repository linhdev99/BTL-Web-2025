<?php
/**
 * @var array $categories
 * @var array $faqQuestions
 * @var int $page
 * @var int $totalPages
 * @var string $keyword
 * @var string $sort
 * @var string|int|null $category_id
 */
?>
<section class="section py-5">
  <div class="container">
    <h2 class="text-center mb-4 fw-bold text-primary">
      💬 Câu hỏi từ cộng đồng
    </h2>

    <form method="get" class="question-filter mb-4 d-flex flex-wrap align-items-center justify-content-center gap-2">
      <input type="text" name="keyword" placeholder="🔍 Tìm kiếm câu hỏi..." class="form-control w-auto"
        value="<?= htmlspecialchars($keyword ?? '') ?>">

      <select name="category_id" class="form-select w-auto">
        <option value="">-- Tất cả danh mục --</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= $cat['id'] ?>" <?= ($category_id == $cat['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <select name="sort" class="form-select w-auto">
        <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Mới nhất</option>
        <option value="oldest" <?= $sort === 'oldest' ? 'selected' : '' ?>>Cũ nhất</option>
      </select>

      <button type="submit" class="btn btn-primary">
        <i class="bi bi-funnel"></i> Lọc
      </button>

      <a href="<?= BASE_URL ?>/questions" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-clockwise"></i> Làm mới
      </a>
    </form>

    <div class="text-center mb-5">
      <a href="<?= BASE_URL ?>/user/ask" class="btn btn-success btn-lg shadow-sm px-4">
        <i class="bi bi-plus-circle"></i> Đặt câu hỏi mới
      </a>
    </div>

    <?php if (!empty($faqQuestions)): ?>
      <div class="question-feed">
        <?php foreach ($faqQuestions as $q): ?>
          <?php
          $userName = htmlspecialchars($q['full_name'] ?? 'Ẩn danh');
          $createdAt = htmlspecialchars($q['created_at'] ?? '');
          $status = $q['status'] ?? 'pending';
          $categoryName = htmlspecialchars($q['category_name'] ?? 'Chưa phân loại');
          $categoryColor = htmlspecialchars($q['category_color'] ?? '#6c757d');
          $excerpt = htmlspecialchars(mb_substr(strip_tags($q['question']), 0, 180));

          $views = (int) ($q['views'] ?? 0);
          $comments = (int) ($q['total_comments'] ?? 0);
          ?>
          <div class="question-card card shadow-sm mb-4">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <?php
                $userName = $q['username'] ?? $q['full_name'] ?? 'guest';
                $avatarUrl = '';
                if (!empty($q['avatar'])) {
                  $avatarUrl = $q['avatar'];
                } else {
                  $avatarUrl = 'https://i.pravatar.cc/100?u=' . urlencode($userName);
                }
                ?>
                <img src="<?= $avatarUrl ?>" alt="Avatar" class="rounded-circle me-2 question-avatar">
                <div>
                  <div class="fw-bold"><?= $userName ?></div>
                  <small class="text-muted">
                    <i class="bi bi-calendar3"></i> <?= $createdAt ?>
                  </small>
                </div>
                <div class="ms-auto">
                  <span
                    class="badge bg-<?= $status === 'answered' ? 'success' : ($status === 'pending' ? 'warning' : 'secondary') ?>">
                    <?= $status === 'answered' ? 'Đã trả lời' : ($status === 'pending' ? 'Chờ duyệt' : ucfirst($status)) ?>
                  </span>
                </div>
              </div>

              <h5 class="fw-bold text-dark mb-2">
                <a href="/questions/<?= htmlspecialchars($q['id']) ?>" class="text-decoration-none text-dark hover-link">
                  <?= htmlspecialchars($q['question']) ?>
                </a>
              </h5>

              <p class="text-muted mb-3"><?= nl2br($excerpt) ?>...</p>

              <div class="question-stats d-flex align-items-center text-muted mb-3">
                <span class="me-3">
                  <i class="bi bi-eye"></i> <?= $views ?> lượt xem
                </span>
                <span>
                  <i class="bi bi-chat-dots"></i> <?= $comments ?> bình luận
                </span>
              </div>

              <div class="d-flex justify-content-between align-items-center">
                <span class="badge category-badge" style="background-color: <?= $categoryColor ?>;">
                  <?= $categoryName ?>
                </span>

                <div class="d-flex align-items-center gap-2">
                  <a href="/questions/<?= htmlspecialchars($q['id']) ?>" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-arrow-right-circle"></i> Xem chi tiết
                  </a>

                  <?php if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $q['user_id']): ?>
                    <form action="<?= BASE_URL ?>/questions/<?= htmlspecialchars($q['id']) ?>/delete" method="post"
                      onsubmit="return confirm('Bạn có chắc muốn xoá câu hỏi này không?');">
                      <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-trash"></i> Xóa
                      </button>
                    </form>
                  <?php endif; ?>

                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- PHÂN TRANG -->
      <?php if ($totalPages > 1): ?>
        <div class="pagination justify-content-center mt-4">
          <a href="<?= $page > 1
            ? '?page=' . ($page - 1) . '&keyword=' . urlencode($keyword) . '&sort=' . urlencode($sort) . '&category_id=' . urlencode($category_id)
            : '#' ?>" class="page-link <?= $page <= 1 ? 'disabled' : '' ?>">&laquo;</a>

          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a class="page-link <?= $i == $page ? 'active' : '' ?>"
              href="?page=<?= $i ?>&keyword=<?= urlencode($keyword) ?>&sort=<?= urlencode($sort) ?>&category_id=<?= urlencode($category_id) ?>">
              <?= $i ?>
            </a>
          <?php endfor; ?>

          <a href="<?= $page < $totalPages
            ? '?page=' . ($page + 1) . '&keyword=' . urlencode($keyword) . '&sort=' . urlencode($sort) . '&category_id=' . urlencode($category_id)
            : '#' ?>" class="page-link <?= $page >= $totalPages ? 'disabled' : '' ?>">&raquo;</a>
        </div>
      <?php endif; ?>

    <?php else: ?>
      <p class="text-center text-muted mt-5">😕 Không có câu hỏi nào được tìm thấy.</p>
    <?php endif; ?>
  </div>
</section>

<style>
  /* =============================
     QUESTION FEED STYLE
  ============================= */
  .section {
    background-color: #f8f9fa;
    min-height: 100vh;
    animation: fadeIn 0.8s ease;
  }

  .question-filter input,
  .question-filter select {
    min-width: 180px;
  }

  .btn-outline-secondary i {
    transition: transform 0.2s ease;
  }

  .btn-outline-secondary:hover i {
    transform: rotate(180deg);
  }

  .question-card {
    border-radius: 16px;
    transition: all 0.3s ease;
  }

  .question-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
  }

  .question-avatar {
    width: 42px;
    height: 42px;
    border: 2px solid #dee2e6;
    object-fit: cover;
  }

  .category-badge {
    font-size: 0.85rem;
    padding: 6px 10px;
    color: #fff;
    border-radius: 10px;
  }

  .question-stats {
    font-size: 0.9rem;
  }

  .hover-link:hover {
    color: #0d6efd;
    text-decoration: underline;
  }

  .pagination .page-link {
    color: #0d6efd;
    border-radius: 6px;
    margin: 0 3px;
  }

  .pagination .active {
    background-color: #0d6efd;
    color: #fff;
    border-color: #0d6efd;
  }

  .pagination .disabled {
    pointer-events: none;
    opacity: 0.5;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(10px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>