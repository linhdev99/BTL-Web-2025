<?php
/**
 * @var array $news
 * @var array $comments
 * @var array $related
 * @var array|null $user
 */
?>

<section class="section py-5">
  <div class="container">

    <!-- ===== TIÊU ĐỀ TRANG ===== -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="fw-bold text-primary mb-0">
        <i class="fa-solid fa-newspaper me-2"></i> Tin tức chi tiết
      </h2>
      <a href="<?= BASE_URL ?>/news" class="btn btn-outline-primary btn-sm">
        <i class="fa-solid fa-list me-1"></i> Xem danh sách tin tức
      </a>
    </div>

    <!-- ===== BÀI VIẾT CHÍNH ===== -->
    <div class="card shadow-sm mb-4 p-4 news-card">
      <?php if (!empty($news['thumbnail'])): ?>
        <img src="<?= htmlspecialchars($news['thumbnail']) ?>" alt="<?= htmlspecialchars($news['title']) ?>"
          class="news-thumbnail rounded mb-4 shadow-sm">
      <?php endif; ?>

      <div class="d-flex align-items-center mb-3 text-muted small">
        <i class="fa-regular fa-user me-1"></i>
        <span class="me-3"><?= htmlspecialchars($news['full_name'] ?? 'Không rõ tác giả') ?></span>
        <i class="fa-regular fa-clock me-1"></i>
        <span><?= date("d/m/Y H:i", strtotime($news['published_at'] ?? $news['created_at'])) ?></span>
      </div>

      <h3 class="fw-bold text-dark mb-3"><?= htmlspecialchars($news['title']) ?></h3>

      <!-- ⭐ Hiển thị đánh giá trung bình -->
      <div class="mb-3">
        <?php
        $avg = floatval($news['avg_rating'] ?? 0);
        $count = intval($news['rating_count'] ?? 0);
        $full = floor($avg);
        $half = ($avg - $full >= 0.5);
        $empty = 10 - $full - ($half ? 1 : 0);
        ?>
        <?php for ($i = 0; $i < $full; $i++): ?><i class="fa-solid fa-star text-warning"></i><?php endfor; ?>
        <?php if ($half): ?><i class="fa-regular fa-star-half-stroke text-warning"></i><?php endif; ?>
        <?php for ($i = 0; $i < $empty; $i++): ?><i class="fa-regular fa-star text-warning"></i><?php endfor; ?>
        <span class="text-muted small ms-1">(<?= number_format($avg, 1) ?>/10 từ <?= $count ?> lượt)</span>
      </div>

      <div class="text-muted fs-6 lh-lg mb-3 content">
        <?= $news['content'] ?>
      </div>
    </div>

    <!-- ===== KHỐI TƯƠNG TÁC NGƯỜI DÙNG (Đánh giá + Bình luận) ===== -->
    <div class="card shadow-sm mb-5">
      <div class="card-header bg-light fw-semibold d-flex justify-content-between align-items-center">
        <span><i class="fa-solid fa-star text-warning me-2"></i> Đánh giá & Bình luận</span>
        <span class="text-muted small">
          <i class="fa-solid fa-star text-warning"></i>
          <?= number_format($avg, 1) ?>/10 (<?= $count ?> lượt)
        </span>
      </div>

      <div class="card-body">
        <?php if (!$user): ?>
          <!-- 🔒 Nếu chưa đăng nhập -->
          <div class="text-center py-3 text-muted">
            <i class="fa-solid fa-lock me-1"></i>
            Vui lòng <a href="/login" class="fw-semibold text-decoration-none">đăng nhập</a> để đánh giá và bình luận.
          </div>

        <?php else: ?>
          <!-- ⭐ Form Đánh giá -->
          <form method="POST" action="/news/<?= (int) $news['id'] ?>/rate" class="rating-form mb-4 text-center">
            <div class="rating-select mb-3">
              <?php for ($i = 10; $i >= 1; $i--): ?>
                <input type="radio" id="star<?= $i ?>" name="star" value="<?= $i ?>" <?= ($i == round($news['user_star'] ?? 0)) ? 'checked' : '' ?>>
                <label for="star<?= $i ?>" title="<?= $i ?>/10"><i class="fa-solid fa-star"></i></label>
              <?php endfor; ?>
            </div>
            <button type="submit" class="btn btn-primary rounded-pill px-4">
              <i class="fa-solid fa-paper-plane me-1"></i> Gửi đánh giá
            </button>
            <?php if (!empty($news['user_star'])): ?>
              <p class="text-muted small mt-2 mb-0">
                Bạn đã đánh giá bài viết này <strong><?= $news['user_star'] ?>/10</strong>.
              </p>
            <?php endif; ?>
          </form>

          <!-- 💬 Form Bình luận -->
          <form method="POST" action="/news/<?= (int) $news['id'] ?>/comment/add"
            class="d-flex align-items-start gap-3 mb-4">
            <img src="<?= !empty($user['avatar'])
              ? BASE_URL . '/' . htmlspecialchars($user['avatar'])
              : 'https://i.pravatar.cc/80?u=' . urlencode($user['full_name'] ?? 'guest') ?>" alt="Avatar"
              class="rounded-circle comment-avatar">
            <div class="flex-grow-1">
              <textarea name="content" class="form-control mb-2" rows="3" placeholder="Nhập bình luận của bạn..."
                required></textarea>
              <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-outline-primary rounded-pill px-4">
                  <i class="fa-solid fa-comment-dots me-1"></i> Gửi bình luận
                </button>
              </div>
            </div>
          </form>
        <?php endif; ?>

        <!-- 🗨️ Danh sách bình luận -->
        <hr>
        <h6 class="fw-semibold text-secondary mb-3"><i class="fa-regular fa-comments me-2"></i> Bình luận</h6>

        <?php if (!empty($comments)): ?>
          <?php foreach ($comments as $c): ?>
            <div class="d-flex align-items-start border-bottom pb-3 mb-3 fade-in">
              <img src="<?= !empty($c['avatar'])
                ? BASE_URL . '/' . htmlspecialchars($c['avatar'])
                : 'https://i.pravatar.cc/80?u=' . urlencode($c['full_name'] ?? 'guest') ?>" alt="Avatar"
                class="rounded-circle me-3 comment-avatar">

              <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <div class="fw-semibold text-dark"><?= htmlspecialchars($c['full_name'] ?? 'Người dùng ẩn') ?></div>
                    <div class="text-muted small mb-1">
                      <i class="fa-regular fa-clock me-1"></i>
                      <?= date("d/m/Y H:i", strtotime($c['created_at'])) ?>
                    </div>
                  </div>
                  <?php if ($user && $user['id'] === $c['user_id']): ?>
                    <form method="POST" action="/news/<?= $news['id'] ?>/comment/delete"
                      onsubmit="return confirm('Xoá bình luận này?');">
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="comment_id" value="<?= $c['id'] ?>">
                      <button type="submit" class="btn btn-sm btn-outline-danger">
                        <i class="fa-solid fa-trash"></i> Xoá
                      </button>
                    </form>
                  <?php endif; ?>
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

    <!-- ===== BÀI VIẾT LIÊN QUAN ===== -->
    <?php if (!empty($related)): ?>
      <hr class="my-5">
      <h4 class="fw-bold text-primary mb-4 text-center">
        <i class="fa-solid fa-newspaper me-2"></i> Bài viết liên quan
      </h4>
      <div class="row g-4">
        <?php foreach ($related as $r): ?>
          <div class="col-md-3 col-sm-6">
            <div class="card h-100 border-0 shadow-sm hover-shadow-sm">
              <?php if (!empty($r['thumbnail'])): ?>
                <img src="<?= htmlspecialchars($r['thumbnail']) ?>" alt="<?= htmlspecialchars($r['title']) ?>"
                  class="card-img-top rounded-top" style="height: 160px; object-fit: cover;">
              <?php endif; ?>
              <div class="card-body">
                <h6 class="fw-semibold text-primary mb-2"><?= htmlspecialchars($r['title']) ?></h6>
                <p class="text-muted small mb-3"><?= htmlspecialchars($r['summary']) ?></p>
                <a href="/news/<?= $r['id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill">Xem chi tiết</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- ===== CSS ===== -->
<style>
  .section {
    background-color: #f8f9fa;
    min-height: 100vh;
    animation: fadeIn 0.8s ease;
  }

  .news-card {
    border-radius: 16px;
    transition: all 0.3s ease;
  }

  .news-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
  }

  .news-thumbnail {
    width: 100%;
    max-height: 420px;
    object-fit: cover;
    border-radius: 12px;
  }

  .comment-avatar {
    width: 45px;
    height: 45px;
    object-fit: cover;
    border: 1px solid #dee2e6;
  }

  .hover-shadow-sm:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
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

  .content img {
    max-width: 100%;
    border-radius: 8px;
    margin: 10px 0;
  }

  .content p {
    margin-bottom: 1rem;
  }

  /* ⭐ Rating */
  .rating-select {
    display: inline-flex;
    flex-direction: row-reverse;
    justify-content: center;
    gap: 3px;
  }

  .rating-select input {
    display: none;
  }

  .rating-select label {
    font-size: 1.8rem;
    color: #ccc;
    cursor: pointer;
    transition: color 0.2s;
  }

  .rating-select label:hover,
  .rating-select label:hover~label,
  .rating-select input:checked+label,
  .rating-select input:checked~label {
    color: #ffc107;
  }
</style>