<?php
$current = $_GET['url'] ?? '/';
function active($path, $current)
{
    return ($current === $path) ? "style='font-weight:bold; color:#d00'" : "";
}
?>

<div style="width:200px;float:left;background:#f3f3f3;height:100vh;padding:10px;box-sizing:border-box;">
    <a <?= active("cms", $current) ?> href="/cms">Dashboard</a><br>
    <a <?= active("cms/products", $current) ?> href="/cms/products">Products</a><br>
    <a <?= active("cms/categories", $current) ?> href="/cms/categories">Categories</a><br>
    <a <?= active("cms/orders", $current) ?> href="/cms/orders">Orders</a><br>
    <a <?= active("cms/users", $current) ?> href="/cms/users">Users</a><br>
</div>

<div style="margin-left:220px; padding:20px;">