<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? "BK Figure Lab" ?></title>

    <style>
        /* ======= GLOBAL ======= */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #fafafa;
        }

        a {
            text-decoration: none;
        }

        /* ======= HEADER ======= */
        header {
            background: #202020;
            color: white;
            padding: 20px 30px;
            border-bottom: 3px solid #ff4d4d;
        }

        header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }

        header .slogan {
            margin-top: 3px;
            font-size: 14px;
            font-style: italic;
            color: #e5e5e5;
        }

        /* ======= NAVBAR ======= */
        nav {
            margin-top: 15px;
        }

        nav a {
            color: #fff;
            margin-right: 20px;
            font-size: 15px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        /* ======= CONTENT ======= */
        .container {
            padding: 25px;
        }

        /* ======= FOOTER ======= */
        footer {
            background: #202020;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 40px;
            font-size: 14px;
        }

        footer small {
            color: #bbbbbb;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <header>
        <h1>BK Figure Lab</h1>
        <div class="slogan">For True Figure Lovers</div>

        <nav>
            <a href="/">Trang chủ</a>
            <a href="/products">Sản phẩm</a>
            <a href="/cart">Giỏ hàng</a>
            <a href="/about">Giới thiệu</a>
        </nav>
    </header>

    <div class="container">