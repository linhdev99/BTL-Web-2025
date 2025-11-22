<h1 class="text-white mb-4"><?= $page_title ?></h1>

<form method="POST" action="/cms/faq/static/edit/<?= $faq['id'] ?>">

    <!-- Phân loại -->
    <div class="mb-3">
        <label class="text-white fw-bold">Thể loại</label>
        <select name="category_id" class="form-control bg-dark text-white">
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= ($faq['category_id'] ?? 1) == $cat['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Câu hỏi -->
    <div class="mb-3">
        <label class="text-white fw-bold">Câu hỏi</label>
        <textarea id="question_editor" name="question"><?= htmlspecialchars($faq['question']) ?></textarea>
    </div>

    <!-- Trả lời -->
    <div class="mb-3">
        <label class="text-white fw-bold">Trả lời</label>
        <textarea id="answer_editor" name="answer"><?= htmlspecialchars($faq['answer']) ?></textarea>
    </div>

    <!-- Thứ tự -->
    <div class="mb-3">
        <label class="text-white fw-bold">Thứ tự</label>
        <input type="number" name="ordering" class="form-control bg-dark text-white" value="<?= $faq['ordering'] ?>">
    </div>

    <!-- Hiển thị -->
    <div class="form-check mb-3">
        <input type="checkbox" name="is_active" class="form-check-input" <?= $faq['is_active'] ? "checked" : "" ?>>
        <label class="form-check-label text-white">Hiển thị</label>
    </div>

    <button class="btn btn-primary"><?= ICON_SAVE ?> Cập nhật</button>
    <a href="/cms/faq/static" class="btn btn-secondary"><?= ICON_BACK ?> Quay lại</a>

</form>

<script>
    $('#question_editor').summernote({
        height: 150,
        placeholder: 'Chỉnh sửa câu hỏi...'
    });
    $('#answer_editor').summernote({
        height: 200,
        placeholder: 'Chỉnh sửa câu trả lời...'
    });
</script>