<h1 class="text-white mb-4"><?= $page_title ?></h1>

<a href="/cms/faq/category/add" class="btn btn-success mb-3">
    <?= ICON_ADD ?> Thêm thể loại
</a>

<table class="table table-dark table-bordered align-middle">
    <thead class="table-secondary text-dark">
        <tr>
            <th width="60">ID</th>
            <th>Tên thể loại</th>
            <th width="120">Hiển thị</th>
            <th width="200">Hành động</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($categories as $cat): ?>
            <tr>
                <td><?= $cat['id'] ?></td>

                <td><?= htmlspecialchars($cat['name']) ?></td>

                <td><?= $cat['is_active'] ? ICON_CHECK : ICON_UNCHECK ?></td>

                <td>
                    <a href="/cms/faq/category/edit/<?= $cat['id'] ?>" class="btn btn-warning btn-sm">
                        <?= ICON_EDIT ?> Sửa
                    </a>

                    <form method="POST" action="/cms/faq/category/delete/<?= $cat['id'] ?>" class="d-inline"
                        onsubmit="return confirm('Bạn có chắc muốn xoá thể loại này?')">

                        <button class="btn btn-danger btn-sm">
                            <?= ICON_DELETE ?> Xóa
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>