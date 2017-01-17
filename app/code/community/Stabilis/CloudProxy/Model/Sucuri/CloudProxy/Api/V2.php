<?php

class Stabilis_CloudProxy_Model_Sucuri_Cloudproxy_Api_V2 extends Stabilis_Core_Model_Abstract {
    
    const API_ACTION_CLEAR_CACHE  = 'clear_cache';
    const API_ACTION_WHITELIST_IP = 'whitelist_ip'
    
    protected function _getCommonParams() {
        $helper = Mage::helper('stabilis_cloudproxy');
        /* @var $helper Stabilis_Cloudproxy_Helper_Data */
        
        return array(
            'k' => $helper->getApiKey(),
            's' => $helper->getSecretKey()
        );
    }
    
    protected function _handleApiErrors($response) {
        
    }
    
    protected function _call($params) {
        
        $helper = Mage::helper('stabilis_cloudproxy');
        /* @var $helper Stabilis_CloudProxy_Helper_Data */
        
        $params += $this->_getCommonParams();
        
        $session = curl_init();
        curl_setopt_array($session, array(
            CURLOPT_URL            => $helper->getApiEndpoint(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT      => $helper->getApiUserAgent(),
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $params,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => true
        ));
        $response = json_decode(curl_exec($session), true);
        curl_close($session);
        return Mage::getModel('stabilis_cloudproxy/sucuri/cloudproxy/api/v2/response')->addData($response);
    }
    
    public function clearCache($file = null) {
        $params = array('a' => static::API_ACTION_CLEAR_CACHE);
        if($file) {
            $params['file'] = $file;
        }
        $response = $this->_call($params);
    }
    
    public function whitelistIp($ip = null) {
        $params = array('a' => static::API_ACTION_WHITELIST_IP);
        if($ip) {
            if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $params['ip'] = $ip;
            } else {
                Mage::throwException("[{$ip}] is not a valid IPv4 Address");
            }
        }
        $response = $this->_call($params);
    }
    
    public function getSettings() {
        //a=show_settings
    }
    
    public function getAuditTrails($date, $query, $offset = 0, $limit = 50) {
        //a=audit_trails
    }
    
    
    
}