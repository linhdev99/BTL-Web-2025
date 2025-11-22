<h1 class="text-white mb-4"><?= $page_title ?></h1>

<a href="/cms/faq/add" class="btn btn-success mb-3">+ Thêm FAQ mới</a>

<table class="table table-dark table-bordered align-middle">
    <thead>
        <tr>
            <th width="50">ID</th>
            <th>Câu hỏi</th>
            <th width="80">Thứ tự</th>
            <th width="80">Hiển thị</th>
            <th width="180">Hành động</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($faqs as $f): ?>
            <tr>
                <td><?= $f['id'] ?></td>
                <td><?= htmlspecialchars($f['question']) ?></td>
                <td><?= $f['ordering'] ?></td>
                <td><?= $f['is_active'] ? '✔' : '✖' ?></td>
                <td>
                    <a href="/cms/faq/edit/<?= $f['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>

                    <form method="POST" action="/cms/faq/delete/<?= $f['id'] ?>" class="d-inline"
                        onsubmit="return confirm('Bạn có chắc muốn xoá FAQ này?')">

                        <button class="btn btn-danger btn-sm">Xoá</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>