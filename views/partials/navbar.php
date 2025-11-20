<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? "CMS - BK Figure Lab" ?></title>

    <style>
        /* ===== GLOBAL ===== */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }

        a {
            text-decoration: none;
        }

        /* ===== HEADER ===== */
        header {
            background: #202020;
            color: white;
            padding: 18px 25px;
            border-bottom: 3px solid #ff9900;
        }

        header h2 {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
        }

        /* ===== NAVBAR ===== */
        nav {
            margin-top: 12px;
        }

        nav a {
            color: #fff;
            font-size: 14px;
            margin-right: 20px;
        }

        nav a:hover {
            color: #ffcc66;
        }

        /* ===== CONTENT ===== */
        .container {
            padding: 25px;
        }

        /* ===== TABLE ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 15px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            background: #eee;
        }

        /* ===== FOOTER ===== */
        footer {
            background: #202020;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 40px;
            font-size: 13px;
        }

        footer small {
            color: #ccc;
            font-size: 11px;
        }
    </style>
</head>

<body>

    <header>
        <h2>CMS Admin Panel — BK Figure Lab</h2>
        <nav>
            <a href="/cms">Dashboard</a>
            <a href="/cms/products">Sản phẩm</a>
            <a href="/cms/categories">Danh mục</a>
            <a href="/cms/orders">Đơn hàng</a>
            <a href="/cms/users">Người dùng</a>
        </nav>
    </header>

    <div class="container">