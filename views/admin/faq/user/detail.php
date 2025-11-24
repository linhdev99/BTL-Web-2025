<h1 class="text-white mb-4"><?= $page_title ?></h1>

<!-- QUESTION INFO -->
<div class="card bg-dark border-secondary p-4 mb-4">
    <h4 class="text-info">Câu hỏi:</h4>
    <p class="text-white"><?= nl2br(htmlspecialchars($question['question'])) ?></p>

    <div class="mt-3">
        <span class="badge bg-primary">
            Người hỏi: <?= htmlspecialchars($question['full_name'] ?? "User #{$question['user_id']}") ?>
        </span>

        <span class="badge bg-info text-dark">
            Thể loại: <?= htmlspecialchars($question['category_name'] ?? "Chưa phân loại") ?>
        </span>

        <span class="badge bg-secondary">
            <?= date("d/m/Y H:i", strtotime($question['created_at'])) ?>
        </span>
    </div>
</div>


<!-- UPDATE QUESTION STATUS -->
<div class="card bg-dark border-secondary p-4 mb-4">
    <h4 class="text-warning mb-3"><i class="fa-solid fa-flag"></i> Trạng thái câu hỏi</h4>

    <form method="POST" action="/cms/faq/user/status/<?= $question['id'] ?>" class="row g-3">
        <div class="col-md-4">
            <select name="status" class="form-control bg-dark text-white">
                <option value="pending" <?= $question['status'] === 'pending' ? 'selected' : '' ?>>Chờ duyệt</option>
                <option value="active" <?= $question['status'] === 'active' ? 'selected' : '' ?>>Hiển thị</option>
                <option value="hidden" <?= $question['status'] === 'hidden' ? 'selected' : '' ?>>Ẩn</option>
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-warning w-100">
                <i class="fa-solid fa-pen"></i> Cập nhật
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
            <div class="mb-3 border-bottom border-secondary pb-2">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-info fw-bold">
                            <?= htmlspecialchars($cmt['full_name'] ?? "User #{$cmt['user_id']}") ?>
                        </div>
                        <div class="text-white">
                            <?= nl2br(htmlspecialchars($cmt['content'])) ?>
                        </div>
                        <div class="text-secondary small">
                            <?= date("d/m/Y H:i", strtotime($cmt['created_at'])) ?>
                        </div>
                    </div>

                    <!-- Delete Button -->
                    <form method="POST" action="/cms/faq/user/detail/<?= $question['id'] ?>/comment/delete/<?= $cmt['id'] ?>"
                        onsubmit="return confirm('Xóa bình luận này?')" class="ms-3">
                        <button class="btn btn-sm btn-danger">
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