<?php

namespace Views;

class ErrorView
{
    public function render()
    {
        http_response_code(404);

        echo "
        <html>
        <head>
            <title>404 - Not Found</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background: #fafafa;
                    text-align: center;
                    padding-top: 80px;
                }
                h1 {
                    font-size: 48px;
                    color: #ff4d4d;
                }
                p {
                    font-size: 18px;
                    color: #666;
                }
                a {
                    color: #007bff;
                    text-decoration: none;
                }
                a:hover {
                    text-decoration: underline;
                }
            </style>
        </head>
        <body>
            <h1>404</h1>
            <p>Trang bạn tìm không tồn tại.</p>
            <p><a href='/'>Quay lại trang chủ</a></p>
        </body>
        </html>
        ";
    }
}
