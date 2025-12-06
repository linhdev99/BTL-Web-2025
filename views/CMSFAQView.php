<?php

namespace Views;

class CMSFAQView
{
    private function render(string $path, array $data = []): void
    {
        extract($data);

        $file = PATH_ROOT . '/views/admin/faq/' . $path;

        if (!file_exists($file)) {
            (new ErrorView)->render();
            return;
        }

        require $file;
    }

    public function renderCategory(array $data): void
    {
        $this->render('category/index.php', $data);
    }

    public function renderCategoryEdit(array $data): void
    {
        $this->render('category/edit.php', $data);
    }

    public function renderCategoryAdd(array $data): void
    {
        $this->render('category/add.php', $data);
    }
}
