<?php

namespace Views;

class HomeView
{
    public function render(array $data = [])
    {
        // extract($data);
        require PATH_ROOT . '/views/client/home.php';
    }
}
