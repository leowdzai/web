<?php

class Affiliate {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function getByUserId($userId) {
        $userId = (int)$userId;
        $result = $this->db->query("SELECT * FROM affiliates WHERE user_id = $userId");
        return $result->fetch_assoc();
    }
    
    public function getReferralCode($userId) {
        $aff = $this->getByUserId($userId);
        return $aff['referral_code'] ?? null;
    }
    
    public function getStats($userId) {
        $userId = (int)$userId;
        $aff = $this->getByUserId($userId);
        
        if (!$aff) return null;
        
        $affiliateId = $aff['id'];
        
        $referrals = $this->db->query("SELECT COUNT(*) as count FROM affiliate_referrals WHERE affiliate_id = $affiliateId")->fetch_assoc();
        $commissions = $this->db->query("SELECT SUM(commission_amount) as total FROM affiliate_commissions WHERE affiliate_id = $affiliateId")->fetch_assoc();
        
        return [
            'referral_code' => $aff['referral_code'],
            'total_referrals' => $referrals['count'],
            'total_commission' => $commissions['total'] ?? 0,
            'available_balance' => $aff['available_balance'],
            'withdrawn' => $aff['withdrawn_amount']
        ];
    }
    
    public function addReferral($affiliateId, $referredUserId) {
        $affiliateId = (int)$affiliateId;
        $referredUserId = (int)$referredUserId;
        
        return $this->db->query("INSERT INTO affiliate_referrals (affiliate_id, referred_user_id) VALUES ($affiliateId, $referredUserId)");
    }
    
    public function addCommission($affiliateId, $orderId, $referralId, $amount) {
        $affiliateId = (int)$affiliateId;
        $orderId = (int)$orderId;
        $referralId = (int)$referralId;
        $amount = (float)$amount;
        
        $sql = "INSERT INTO affiliate_commissions (affiliate_id, order_id, referral_id, commission_amount) 
                VALUES ($affiliateId, $orderId, $referralId, $amount)";
        
        if ($this->db->query($sql)) {
            return $this->db->query("UPDATE affiliates SET available_balance = available_balance + $amount WHERE id = $affiliateId");
        }
        return false;
    }
    
    public function requestWithdraw($affiliateId, $amount, $bankAccount) {
        $affiliateId = (int)$affiliateId;
        $amount = (float)$amount;
        $bankAccount = $this->db->escape($bankAccount);
        
        $sql = "INSERT INTO affiliate_withdrawals (affiliate_id, amount, bank_account) VALUES ($affiliateId, $amount, '$bankAccount')";
        
        if ($this->db->query($sql)) {
            return $this->db->query("UPDATE affiliates SET available_balance = available_balance - $amount WHERE id = $affiliateId");
        }
        return false;
    }
}
