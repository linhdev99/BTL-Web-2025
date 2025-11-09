<?php
define('PROTOCOL', isset($_SERVER['HTTPS']) ? 'https://' : 'http://');
define('ROOT_URL', PROTOCOL . $_SERVER['HTTP_HOST']);

$database_server = "localhost";
$database_port = "3306";
$database_username = "root";
$database_password = "";
$database_name = "bkshop";
$session_time = 3600;
$upload_image_url = ROOT_URL . '/image/upload';

// // VNPAY
// $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
// $vnp_TmnCode = '93OQVSQD';
// $vnp_HashSecret = 'HPEMBCTNFJEBSVJHOEXYCLYCTJCHNXTG';
// $vnp_ReturnUrl = ROOT_URL . "/payment/VNPay/result";
// $vnp_IpnUrl = ROOT_URL . "/payment/VNPay/ipn";
