<?php
// VNPAY Configuration
return [
    'vnp_TmnCode' => '8KRPECE1', // Mã website của bạn trên VNPAY
    'vnp_HashSecret' => 'MOQ4P3GTVENZTPNZ8G35AQJFPKQUKWWY', // Chuỗi bí mật
    'vnp_Url' => 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html', // URL sandbox
    'vnp_ReturnUrl' => 'http://localhost/duan/frontend/index.php?page=vnpay_return', // URL trả về
    'vnp_apiUrl' => 'http://sandbox.vnpayment.vn/merchant_webapi/merchant.html',
    'api_url' => 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html',
    'start_time' => date('YmdHis'),
    'expire_time' => date('YmdHis', strtotime('+15 minutes')),
    'vnp_Version' => '2.1.0',
    'vnp_Command' => 'pay',
    'vnp_CurrCode' => 'VND',
    'vnp_Locale' => 'vn',
    'vnp_OrderType' => 'billpayment'
];
?>
