<?php

class Payment {
    public static function createVNPayUrl($order) {
        $vnp_TxnRef = $order['order_number'];
        $vnp_Amount = $order['final_amount'] * 100;
        $vnp_OrderInfo = 'Thanh toan don hang: ' . $order['order_number'];
        
        $inputData = [
            'vnp_Version' => '2.1.0',
            'vnp_TmnCode' => VNPAY_TMN_CODE,
            'vnp_Amount' => intval($vnp_Amount),
            'vnp_Command' => 'pay',
            'vnp_CreateDate' => date('YmdHis'),
            'vnp_CurrCode' => 'VND',
            'vnp_IpAddr' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
            'vnp_Locale' => 'vn',
            'vnp_OrderInfo' => $vnp_OrderInfo,
            'vnp_ReturnUrl' => APP_URL . '/payment/vnpay-callback.php',
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
        
        $vnp_SecureHash = hash_hmac('sha512', $hashdata, VNPAY_HASH_SECRET);
        return VNPAY_URL . '?' . $query . 'vnp_SecureHash=' . $vnp_SecureHash;
    }
    
    public static function verifyVNPayCallback($data) {
        $vnp_SecureHash = $data['vnp_SecureHash'] ?? '';
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
        
        $secureHash = hash_hmac('sha512', $hashdata, VNPAY_HASH_SECRET);
        return strcmp($secureHash, $vnp_SecureHash) == 0 && ($data['vnp_ResponseCode'] ?? '') == '00';
    }
}

?>
