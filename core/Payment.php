<?php

class Payment {
    private $config;
    
    public function __construct() {
        $this->config = require __DIR__ . '/../config/payment.php';
    }
    
    public function createVNPayUrl($order) {
        $vnpay = $this->config['vnpay'];
        
        $vnp_TxnRef = $order['order_number'];
        $vnp_Amount = $order['final_amount'] * 100;
        $vnp_OrderInfo = 'Thanh toan don hang: ' . $order['order_number'];
        
        $inputData = [
            'vnp_Version' => '2.1.0',
            'vnp_TmnCode' => $vnpay['tmn_code'],
            'vnp_Amount' => intval($vnp_Amount),
            'vnp_Command' => 'pay',
            'vnp_CreateDate' => date('YmdHis'),
            'vnp_CurrCode' => 'VND',
            'vnp_IpAddr' => $_SERVER['REMOTE_ADDR'],
            'vnp_Locale' => 'vn',
            'vnp_OrderInfo' => $vnp_OrderInfo,
            'vnp_ReturnUrl' => $vnpay['return_url'],
            'vnp_TxnRef' => $vnp_TxnRef,
        ];
        
        ksort($inputData);
        $query = '';
        $i = 0;
        $hashdata = '';
        
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . '=' . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . '=' . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . '=' . urlencode($value) . '&';
        }
        
        $vnp_SecureHash = hash_hmac('sha512', $hashdata, $vnpay['hash_secret']);
        return $vnpay['url'] . '?' . $query . 'vnp_SecureHash=' . $vnp_SecureHash;
    }
    
    public function verifyVNPayCallback($data) {
        $vnpay = $this->config['vnpay'];
        $vnp_SecureHash = $data['vnp_SecureHash'];
        unset($data['vnp_SecureHash']);
        
        ksort($data);
        $hashdata = '';
        $i = 0;
        
        foreach ($data as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . '=' . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . '=' . urlencode($value);
                $i = 1;
            }
        }
        
        $secureHash = hash_hmac('sha512', $hashdata, $vnpay['hash_secret']);
        return strcmp($secureHash, $vnp_SecureHash) == 0 && $data['vnp_ResponseCode'] == '00';
    }
}
