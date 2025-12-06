<?php

namespace Views;

class CMSFAQView
{
    private function render(string $path, array $data = []): void
    {
        extract($data);

        $file = PATH_ROOT . '/views/admin/faq/' . $path . ".php";

        if (!file_exists($file)) {
            (new ErrorView)->render();
            return;
        }

        require $file;
    }

    public function renderCategory(array $data): void
    {
        $this->render('category/index', $data);
    }

    public function renderCategoryEdit(array $data): void
    {
        $this->render('category/edit', $data);
    }

    public function renderCategoryAdd(array $data): void
    {
        $this->render('category/add', $data);
    }

    public function renderStatic(array $data): void
    {
        $this->render('static/index', $data);
    }

    public function renderStaticAdd(array $data): void
    {
        $this->render('static/add', $data);
    }

    public function renderStaticEdit(array $data): void
    {
        $this->render('static/edit', $data);
    }
}
