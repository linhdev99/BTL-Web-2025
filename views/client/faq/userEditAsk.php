<?php
/**
 * @var string $page_title
 * @var array $categories
 * @var array $question
 */
?>
<section class="section py-5">
  <div class="container">
    <h2 class="text-center mb-4 fw-bold text-primary">
      ✏️ <?= htmlspecialchars($page_title) ?>
    </h2>

    <div class="card shadow-sm mx-auto p-4" style="max-width: 650px;">
      <form action="<?= BASE_URL ?>/questions/<?= htmlspecialchars($question['id']) ?>/edit" method="post">

        <!-- Danh mục -->
        <div class="mb-3">
          <label for="category_id" class="form-label fw-bold">
            <i class="bi bi-tags"></i> Chọn danh mục
          </label>
          <select name="category_id" id="category_id" class="form-select" required>
            <?php foreach ($categories as $cat): ?>
              <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $question['category_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Câu hỏi -->
        <div class="mb-3">
          <label for="question" class="form-label fw-bold">
            <i class="bi bi-chat-dots"></i> Nội dung câu hỏi
          </label>
          <textarea name="question" id="question" rows="6" class="form-control" placeholder="Nhập nội dung câu hỏi..."
            required><?= htmlspecialchars($question['question'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>

        <!-- Nút hành động -->
        <div class="text-center mt-4">
          <button type="submit" class="btn btn-primary px-4">
            <i class="bi bi-save"></i> Cập nhật
          </button>
          <a href="<?= BASE_URL ?>/questions" class="btn btn-outline-secondary ms-2">
            <i class="bi bi-arrow-left"></i> Quay lại
          </a>
        </div>
      </form>
    </div>
  </div>
</section>

<style>
  .section {
    background-color: #f8f9fa;
    min-height: 100vh;
    animation: fadeIn 0.6s ease;
  }

  .card {
    border-radius: 16px;
    border: none;
  }

  .form-label {
    color: #333;
  }

  textarea.form-control {
    resize: vertical;
    border-radius: 10px;
  }

  .btn-primary {
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
  }

  .btn-outline-secondary {
    border-radius: 10px;
    transition: all 0.3s ease;
  }

  .btn-outline-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(108, 117, 125, 0.2);
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