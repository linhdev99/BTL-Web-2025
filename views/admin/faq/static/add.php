<h1 class="text-white mb-4"><?= $page_title ?></h1>

<form method="POST" action="/cms/faq/static/add">

    <!-- Phân loại -->
    <div class="mb-3">
        <label class="text-white fw-bold">Thể loại</label>
        <select name="category_id" class="form-control bg-dark text-white">
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>">
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Câu hỏi -->
    <div class="mb-3">
        <label class="text-white fw-bold">Câu hỏi</label>
        <textarea id="question_editor" name="question"></textarea>
    </div>

    <!-- Trả lời -->
    <div class="mb-3">
        <label class="text-white fw-bold">Trả lời</label>
        <textarea id="answer_editor" name="answer"></textarea>
    </div>

    <!-- Thứ tự -->
    <div class="mb-3">
        <label class="text-white fw-bold">Thứ tự</label>
        <input type="number" name="ordering" class="form-control bg-dark text-white" value="0">
    </div>

    <!-- Hiển thị -->
    <div class="form-check mb-3">
        <input type="checkbox" name="is_active" class="form-check-input" checked>
        <label class="form-check-label text-white">Hiển thị</label>
    </div>

    <button class="btn btn-success"><?= ICON_ADD ?> Thêm FAQ</button>
    <a href="/cms/faq/static" class="btn btn-secondary"><?= ICON_BACK ?> Quay lại</a>

</form>

<script>
    $('#question_editor').summernote({
        height: 150,
        placeholder: 'Nhập câu hỏi FAQ...'
    });
    $('#answer_editor').summernote({
        height: 200,
        placeholder: 'Nhập câu trả lời FAQ...'
    });
</script>