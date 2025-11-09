<?php
namespace Views;
class ErrorView { public function render(){ http_response_code(404); echo '<h1>Admin 404</h1>'; } }
?>