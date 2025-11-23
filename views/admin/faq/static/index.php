<h1 class="text-white mb-4"><?= $page_title ?></h1>

<a href="/cms/faq/static/add" class="btn btn-success mb-3">
    <?= ICON_ADD ?> Thêm FAQ tĩnh
</a>

<table class="table table-dark table-bordered align-middle">
    <thead class="table-secondary text-dark">
        <tr>
            <th width="60">ID</th>
            <th width="180">Thể loại</th>
            <th>Câu hỏi</th>
            <th width="80">Thứ tự</th>
            <th width="80">Hiển thị</th>
            <th width="200">Hành động</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($staticFaq as $f): ?>
            <tr>
                <td><?= $f['id'] ?></td>

                <td>
                    <span class="badge faq-category-badge category-<?= htmlspecialchars($f['category_id'] ?? 1) ?>">
                        <?= htmlspecialchars($categoriesMap[$f['category_id'] ?? 1]) ?>
                    </span>
                </td>

                <td><?= htmlspecialchars(strip_tags($f['question'])) ?></td>

                <td><?= $f['ordering'] ?></td>

                <td><?= $f['is_active'] ? ICON_CHECK : ICON_UNCHECK ?></td>

                <td>
                    <a href="/cms/faq/static/edit/<?= $f['id'] ?>" class="btn btn-warning btn-sm">
                        <?= ICON_EDIT ?> Sửa
                    </a>

                    <form method="POST" action="/cms/faq/static/delete/<?= $f['id'] ?>" class="d-inline"
                        onsubmit="return confirm('Xóa FAQ này?')">

                        <button class="btn btn-danger btn-sm">
                            <?= ICON_DELETE ?> Xóa
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>