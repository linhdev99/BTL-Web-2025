<h1 class="text-white mb-4"><?= $page_title ?></h1>

<form method="POST" action="/cms/faq/category/add">

    <div class="mb-3">
        <label class="text-white fw-bold">Tên thể loại</label>
        <input type="text" name="name" class="form-control bg-dark text-white" required>
    </div>

    <div class="form-check mb-3">
        <input type="checkbox" name="is_active" class="form-check-input" checked>
        <label class="form-check-label text-white">Hiển thị</label>
    </div>

    <button class="btn btn-success">
        <?= ICON_ADD ?> Thêm
    </button>

    <a href="/cms/faq/category" class="btn btn-secondary">
        <?= ICON_BACK ?> Quay lại
    </a>
</form>