<?php

return [
    'vnpay' => [
        'tmn_code' => getenv('VNPAY_TMN_CODE'),
        'hash_secret' => getenv('VNPAY_HASH_SECRET'),
        'url' => 'https://sandbox.vnpayment.vn/paygate',
        'return_url' => getenv('APP_URL') . '/payment/vnpay-callback.php'
    ],
    'momo' => [
        'partner_code' => getenv('MOMO_PARTNER_CODE'),
        'access_key' => getenv('MOMO_ACCESS_KEY'),
        'secret_key' => getenv('MOMO_SECRET_KEY'),
        'endpoint' => 'https://test-payment.momo.vn/v2/gateway/api/create'
    ]
];
