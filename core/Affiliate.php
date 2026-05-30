<?php

require_once 'Database.php';

class Affiliate {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function getByUserId($userId) {
        $userId = (int)$userId;
        $result = $this->db->query("SELECT * FROM affiliates WHERE user_id = $userId LIMIT 1");
        return $result ? $result->fetch_assoc() : null;
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
        
        $referrals = $this->db->query("SELECT COUNT(*) as count FROM affiliate_referrals WHERE affiliate_id = $affiliateId");
        $referrals = $referrals ? $referrals->fetch_assoc() : ['count' => 0];
        
        $commissions = $this->db->query("SELECT SUM(commission_amount) as total FROM affiliate_commissions WHERE affiliate_id = $affiliateId AND status = 'approved'");
        $commissions = $commissions ? $commissions->fetch_assoc() : ['total' => 0];
        
        return [
            'id' => $aff['id'],
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
        
        // Kiểm tra đã có referral chưa
        $check = $this->db->query("SELECT id FROM affiliate_referrals WHERE affiliate_id = $affiliateId AND referred_user_id = $referredUserId");
        if ($check && $check->num_rows > 0) {
            return true;
        }
        
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
        
        if ($amount < MIN_WITHDRAW) {
            return false;
        }
        
        $sql = "INSERT INTO affiliate_withdrawals (affiliate_id, amount, bank_account) VALUES ($affiliateId, $amount, '$bankAccount')";
        
        if ($this->db->query($sql)) {
            return $this->db->query("UPDATE affiliates SET available_balance = available_balance - $amount WHERE id = $affiliateId");
        }
        return false;
    }
}

?>
