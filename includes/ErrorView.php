<?php
namespace Views;
class ErrorView
{
    public function render()
    {
        http_response_code(404);
        echo '<h1>404 Not Found</h1>';
    }
}
?>