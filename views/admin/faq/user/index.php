<h1 class="text-white mb-4"><?= $page_title ?></h1>

<?php
// Helper giữ query khi phân trang
function keepQuery($remove = [])
{
    $questionuery = $_GET;
    foreach ($remove as $r)
        unset($questionuery[$r]);
    $question = http_build_query($questionuery);
    return $question ? '&' . $question : '';
}
?>

<form method="GET" action="/cms/faq/user" class="row g-3 mb-4">

    <!-- Search -->
    <div class="col-md-4">
        <input type="text" name="keyword" class="form-control bg-dark text-white" placeholder="Tìm theo câu hỏi..."
            value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
    </div>

    <!-- Filter Category -->
    <div class="col-md-3">
        <select name="category_id" class="form-control bg-dark text-white">
            <option value="">-- Tất cả thể loại --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= isset($_GET['category_id']) && $_GET['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Sort -->
    <div class="col-md-3">
        <select name="sort" class="form-control bg-dark text-white">
            <option value="newest" <?= (($_GET['sort'] ?? '') === 'newest') ? 'selected' : '' ?>>Mới nhất</option>
            <option value="oldest" <?= (($_GET['sort'] ?? '') === 'oldest') ? 'selected' : '' ?>>Cũ nhất</option>
        </select>
    </div>

    <!-- Button -->
    <div class="col-md-2">
        <button class="btn btn-primary w-100">
            <i class="fa-solid fa-filter"></i> Lọc
        </button>
    </div>

</form>


<!-- LIST QUESTIONS -->
<table class="table table-dark table-bordered align-middle">
    <thead class="table-secondary text-dark">
        <tr>
            <th width="60">ID</th>
            <th width="160">Người hỏi</th>
            <th width="200">Thể loại</th>
            <th>Câu hỏi</th>
            <th width="140">Trạng thái</th>
            <th width="200">Hành động</th>
        </tr>
    </thead>

    <tbody>
        <?php if (empty($faqQuestions)): ?>
            <tr>
                <td colspan="6" class="text-center text-white-50 py-4">
                    Không tìm thấy kết quả phù hợp.
                </td>
            </tr>
        <?php endif; ?>

        <?php foreach ($faqQuestions as $question): ?>
            <tr>

                <td><?= $question['id'] ?></td>

                <td><?= htmlspecialchars($question['full_name'] ?? 'User #' . $question['user_id']) ?></td>

                <td>
                    <span class="badge faq-category-badge category-<?= $question['category_id'] ?? 1 ?>">
                        <?= htmlspecialchars($question['category_name'] ?? 'Chưa phân loại') ?>
                    </span>
                </td>

                <td><?= htmlspecialchars(strip_tags($question['question'])) ?></td>

                <td>
                    <?php if ($question['status'] === 'pending'): ?>
                        <span class="badge bg-warning text-dark">Chờ duyệt</span>
                    <?php elseif ($question['status'] === 'active'): ?>
                        <span class="badge bg-success">Hiển thị</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Ẩn</span>
                    <?php endif; ?>
                </td>

                <td>
                    <a href="/cms/faq/user/detail/<?= $question['id'] ?>" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-eye"></i> Chi tiết
                    </a>

                    <form method="POST" action="/cms/faq/user/delete/<?= $question['id'] ?>" class="d-inline"
                        onsubmit="return confirm('Xóa câu hỏi này?')">
                        <button class="btn btn-danger btn-sm">
                            <?= ICON_DELETE ?> Xóa
                        </button>
                    </form>
                </td>

            </tr>
        <?php endforeach; ?>

    </tbody>
</table>


<!-- PAGINATION -->
<?php if ($totalPages > 1): ?>
    <nav>
        <ul class="pagination justify-content-center">

            <!-- Previous -->
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link bg-dark text-white" href="?page=<?= $page - 1 ?><?= keepQuery(['page']) ?>">
                    &laquo;
                </a>
            </li>

            <!-- Number Pages -->
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link bg-dark text-white" href="?page=<?= $i ?><?= keepQuery(['page']) ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Next -->
            <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                <a class="page-link bg-dark text-white" href="?page=<?= $page + 1 ?><?= keepQuery(['page']) ?>">
                    &raquo;
                </a>
            </li>

        </ul>
    </nav>
<?php endif; ?>