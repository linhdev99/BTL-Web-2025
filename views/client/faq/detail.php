<?php
$faq = $faq ?? [];
$category = $category ?? ['name' => 'Khác', 'color' => '#6c757d'];
$user = $user ?? null;

$image = !empty($faq['image'])
  ? htmlspecialchars($faq['image'])
  : 'https://picsum.photos/seed/faq' . htmlspecialchars($faq['id'] ?? rand(1, 9999)) . '/800/400';
?>
<section class="section py-5">
  <div class="container">
    <div class="faq-header text-center mb-5">
      <h2 class="fw-bold text-primary fade-in">💬 Chi tiết câu hỏi thường gặp (FAQ)</h2>
      <p class="text-muted fade-in delay-1">Tìm hiểu thông tin chi tiết cho câu hỏi bạn quan tâm</p>
    </div>

    <div class="row justify-content-center fade-in delay-2">
      <div class="col-lg-8">
        <div class="card faq-detail-card shadow-sm border-0 overflow-hidden">
          <div class="faq-img-wrapper">
            <img src="<?= $image ?>" alt="FAQ Image" class="faq-img">
            <div class="faq-category-badge"
              style="background-color: <?= htmlspecialchars($category['color'] ?? '#6c757d') ?>;">
              <?= htmlspecialchars($category['name'] ?? 'Khác') ?>
            </div>
          </div>

          <div class="card-body p-4">
            <!-- CÂU HỎI -->
            <div class="faq-question-box mb-4">
              <h5 class="fw-bold text-dark mb-2"><i class="fa-solid fa-circle-question text-primary"></i> Câu hỏi</h5>
              <p class="faq-question-text"><?= $faq['question'] ?? 'Không có câu hỏi' ?></p>
            </div>

            <!-- CÂU TRẢ LỜI -->
            <div class="faq-answer-box mb-4">
              <h5 class="fw-bold text-success mb-2"><i class="fa-solid fa-lightbulb"></i> Trả lời</h5>
              <div class="faq-answer text-secondary fade-in delay-1">
                <?= $faq['answer'] ?? 'Chưa có nội dung' ?>
              </div>
            </div>

            <div class="faq-meta text-muted small mb-4">
              <i class="fa-regular fa-calendar"></i> Cập nhật: <?= htmlspecialchars($faq['updated_at'] ?? '-') ?>
              <?php if (!empty($faq['ordering'])): ?>
                &nbsp; | &nbsp;
                <i class="fa-solid fa-list-ol"></i> Thứ tự: <?= (int) $faq['ordering'] ?>
              <?php endif; ?>
            </div>

            <div class="d-flex align-items-center">
              <a href="/faq" class="btn btn-outline-primary">
                <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách
              </a>
              <?php if (isset($user['role']) && $user['role'] === 'admin'): ?>
                <a href="/cms/faq/static/edit/<?= $faq['id'] ?>" class="btn btn-warning ms-2">
                  <i class="fa-solid fa-pen-to-square"></i> Chỉnh sửa
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
  /* =============================
   FAQ DETAIL PAGE STYLE
   ============================= */
  .section {
    background-color: #f8f9fa;
    min-height: 100vh;
    animation: fadeIn 0.8s ease;
  }

  .faq-detail-card {
    border-radius: 16px;
    background: #fff;
    transition: box-shadow 0.3s ease, transform 0.3s ease;
  }

  .faq-detail-card:hover {
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    transform: translateY(-3px);
  }

  /* Image header */
  .faq-img-wrapper {
    position: relative;
    height: 300px;
    overflow: hidden;
  }

  .faq-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
  }

  .faq-detail-card:hover .faq-img {
    transform: scale(1.05);
  }

  /* Category badge */
  .faq-category-badge {
    position: absolute;
    bottom: 15px;
    left: 15px;
    background-color: #6c757d;
    color: #fff;
    padding: 6px 12px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.9rem;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
    animation: slideUp 0.8s ease;
  }

  /* Question + Answer Boxes */
  .faq-question-box,
  .faq-answer-box {
    padding: 18px 20px;
    border-radius: 12px;
    background-color: #f1f5f9;
    transition: background 0.3s ease;
  }

  .faq-answer-box {
    background-color: #fefefe;
    border-left: 4px solid #198754;
  }

  .faq-question-box:hover {
    background-color: #e9f2ff;
  }

  .faq-question-text {
    font-size: 1.1rem;
    color: #212529;
    line-height: 1.6;
  }

  .faq-answer {
    line-height: 1.7;
    font-size: 1.05rem;
  }

  /* Fade-in animations */
  .fade-in {
    opacity: 0;
    transform: translateY(10px);
    animation: fadeInUp 0.8s ease forwards;
  }

  .fade-in.delay-1 {
    animation-delay: 0.2s;
  }

  .fade-in.delay-2 {
    animation-delay: 0.4s;
  }

  @keyframes fadeInUp {
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

  /* Buttons */
  .btn {
    transition: all 0.25s ease;
  }

  .btn:hover {
    transform: scale(1.03);
  }
</style>