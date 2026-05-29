<?php

return [
    'name' => 'Digital Marketplace',
    'url' => getenv('APP_URL') ?: 'http://localhost',
    'debug' => (bool)getenv('APP_DEBUG', false),
    'timezone' => 'Asia/Ho_Chi_Minh',
    'affiliate_commission' => 10, // 10% commission
    'min_withdraw' => 100000, // 100k VND
];
