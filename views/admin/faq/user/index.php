<h1 class="text-white mb-4"><?= $page_title ?></h1>

<table class="table table-dark table-bordered align-middle">
    <thead class="table-secondary text-dark">
        <tr>
            <th width="60">ID</th>
            <th width="160">Người hỏi</th>
            <th width="200">Thể loại</th>
            <th>Câu hỏi</th>
            <th width="150">Trạng thái</th>
            <th width="200">Hành động</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($userQuestions as $q): ?>
            <tr>

                <td><?= $q['id'] ?></td>

                <td><?= htmlspecialchars($q['full_name'] ?? "User #{$q['user_id']}") ?></td>

                <td>
                    <span class="badge bg-info text-dark">
                        <?= htmlspecialchars($q['category_name'] ?? 'Chưa phân loại') ?>
                    </span>
                </td>

                <td><?= htmlspecialchars(strip_tags($q['question'])) ?></td>

                <td>
                    <?php if ($q['status'] === 'pending'): ?>
                        <span class="badge bg-warning text-dark">Chờ xử lý</span>
                    <?php elseif ($q['status'] === 'active'): ?>
                        <span class="badge bg-success">Hiển thị</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Ẩn</span>
                    <?php endif; ?>
                </td>

                <td>
                    <a href="/cms/faq/user/detail/<?= $q['id'] ?>" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-eye"></i> Chi tiết
                    </a>

                    <form method="POST" action="/cms/faq/user/delete/<?= $q['id'] ?>" class="d-inline"
                        onsubmit="return confirm('Bạn có chắc muốn xoá câu hỏi này?')">

                        <button class="btn btn-danger btn-sm">
                            <?= ICON_DELETE ?> Xóa
                        </button>
                    </form>
                </td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>