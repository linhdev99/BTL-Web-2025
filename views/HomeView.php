<?php

namespace Views;

class HomeView
{
    public function render(array $data = [])
    {
        extract($data);

        // include layout
        include __DIR__ . '/partials/header.php';

        echo "<h1>{$page_title}</h1>";
        echo "<p>Đây là trang Home.</p>";

        include __DIR__ . '/partials/footer.php';
    }
}
