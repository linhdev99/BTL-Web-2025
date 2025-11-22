<h1 class="text-white mb-4"><?= $page_title ?></h1>

<!-- SEARCH / FILTER / SORT -->
<form method="GET" action="/cms/faq/user" class="row g-3 mb-4">

    <!-- Search theo câu hỏi -->
    <div class="col-md-4">
        <input type="text" name="keyword" class="form-control bg-dark text-white" placeholder="Tìm theo câu hỏi..."
            value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
    </div>

    <!-- Lọc theo thể loại -->
    <div class="col-md-3">
        <select name="category_id" class="form-control bg-dark text-white">
            <option value="">-- Tất cả thể loại --</option>

            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= (($_GET['category_id'] ?? '') == $cat['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>

        </select>
    </div>

    <!-- Sort theo ngày -->
    <div class="col-md-3">
        <select name="sort" class="form-control bg-dark text-white">
            <option value="newest" <?= (($_GET['sort'] ?? '') === 'newest') ? 'selected' : '' ?>>
                Mới nhất
            </option>
            <option value="oldest" <?= (($_GET['sort'] ?? '') === 'oldest') ? 'selected' : '' ?>>
                Cũ nhất
            </option>
        </select>
    </div>

    <!-- Button -->
    <div class="col-md-2">
        <button class="btn btn-primary w-100">
            <i class="fa-solid fa-filter"></i> Lọc
        </button>
    </div>

</form>

<!-- DANH SÁCH CÂU HỎI USER -->
<table class="table table-dark table-bordered align-middle">
    <thead class="table-secondary text-dark">
        <tr>
            <th width="60">ID</th>
            <th width="180">Người hỏi</th>
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

                <!-- USER NAME -->
                <td><?= htmlspecialchars($q['full_name'] ?? "User #{$q['user_id']}") ?></td>

                <!-- CATEGORY -->
                <td>
                    <span class="badge bg-info text-dark">
                        <?= htmlspecialchars($q['category_name'] ?? 'Chưa phân loại') ?>
                    </span>
                </td>

                <!-- QUESTION -->
                <td><?= htmlspecialchars(strip_tags($q['question'])) ?></td>

                <!-- STATUS -->
                <td>
                    <?php if ($q['status'] === 'pending'): ?>
                        <span class="badge bg-warning text-dark">Chờ xử lý</span>
                    <?php elseif ($q['status'] === 'active'): ?>
                        <span class="badge bg-success">Hiển thị</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Ẩn</span>
                    <?php endif; ?>
                </td>

                <!-- ACTION -->
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