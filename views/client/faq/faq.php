<?php

$roleId = (!empty($user['role_id']) && (int) $user['role_id'] > 0)
  ? (int) $user['role_id']
  : 3;

if ($roleId > 2) {
  $roleId = 3;
}

$isAdminOrStaff = in_array($roleId, [1, 2]);
?>

<section class="section py-5">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold text-primary">💬 Câu hỏi thường gặp (FAQ)</h2>
      <p class="text-muted">Giải đáp những thắc mắc phổ biến của khách hàng</p>

      <a href="/questions" class="btn btn-primary btn-lg mt-3 see-more-btn">
        <i class="fa-solid fa-circle-question me-2"></i> Xem thêm
      </a>
    </div>

    <?php if (!empty($faqs)): ?>
      <div class="row g-4">
        <?php foreach ($faqs as $faq): ?>
          <?php
          // Thông tin danh mục
          $categoryName = !empty($faq['category_name']) ? $faq['category_name'] : 'Chưa phân loại';
          $categoryColor = !empty($faq['category_color']) ? $faq['category_color'] : '#6c757d';
          $isActive = isset($faq['is_active']) ? (bool) $faq['is_active'] : false;

          // Ảnh minh họa
          $image = !empty($faq['image'])
            ? htmlspecialchars($faq['image'])
            : 'https://picsum.photos/seed/faq' . htmlspecialchars($faq['id'] ?? rand(1, 9999)) . '/400/250';
          ?>
          <div class="col-md-6 col-lg-4">
            <div class="card faq-card h-100 shadow-sm">
              <div class="faq-img-wrapper">
                <img src="<?= $image ?>" alt="FAQ Image" class="faq-img">
                <div class="faq-category-badge" style="background-color: <?= htmlspecialchars($categoryColor) ?>;">
                  <?= htmlspecialchars($categoryName) ?>
                </div>
              </div>

              <div class="card-body d-flex flex-column">
                <h5 class="card-title fw-bold text-dark mb-2">
                  <a href="faq/<?= htmlspecialchars($faq['id']) ?>" class="text-decoration-none text-dark">
                    <?= htmlspecialchars(strip_tags($faq['question'])) ?>
                  </a>
                </h5>

                <p class="card-text text-muted flex-grow-1">
                  <?= nl2br(htmlspecialchars(strip_tags(mb_substr($faq['answer'], 0, 130)))) ?>...
                </p>

                <?php if ($isAdminOrStaff): ?>
                  <div class="faq-status mt-2 mb-3">
                    <span class="badge <?= $isActive ? 'bg-success' : 'bg-danger' ?>">
                      <?= $isActive ? 'Hoạt động' : 'Ngừng hoạt động' ?>
                    </span>
                  </div>
                <?php endif; ?>

                <a href="faq/<?= htmlspecialchars($faq['id']) ?>"
                  class="btn btn-outline-primary btn-sm mt-auto align-self-start">
                  <i class="fa-solid fa-comments"></i> Xem chi tiết
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="alert alert-info text-center shadow-sm">Không có FAQ nào được tìm thấy.</div>
    <?php endif; ?>
  </div>
</section>

<style>
  /* =============================
     FAQ PAGE STYLES
  ============================= */
  .section {
    background-color: #f8f9fa;
    min-height: 100vh;
    animation: fadeIn 1s ease;
  }

  .faq-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    background: #fff;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
  }

  .faq-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  }

  /* Image */
  .faq-img-wrapper {
    position: relative;
    height: 180px;
    overflow: hidden;
  }

  .faq-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
  }

  .faq-card:hover .faq-img {
    transform: scale(1.08);
  }

  /* Category badge */
  .faq-category-badge {
    position: absolute;
    bottom: 10px;
    left: 10px;
    padding: 5px 12px;
    border-radius: 12px;
    color: #fff;
    font-size: 0.85rem;
    font-weight: 600;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    animation: slideUp 0.6s ease;
  }

  /* Status badge */
  .faq-status .badge {
    font-size: 0.8rem;
    padding: 4px 8px;
    border-radius: 8px;
  }

  /* Animations */
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(15px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes slideUp {
    from {
      opacity: 0;
      transform: translateY(10px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Text */
  .card-title a:hover {
    color: #0d6efd;
    text-decoration: underline;
  }

  /* Button hover */
  .btn {
    transition: all 0.25s ease;
  }

  .btn:hover {
    transform: scale(1.05);
  }
</style>