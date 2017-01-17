<?php

abstract class Stabilis_CloudProxy_Helper_Abstract extends Stabilis_Core_Helper_Abstract {
    
    const XML_PATH_ENABLED        = 'stabilis_cloudproxy/general/enabled';
    const XML_PATH_API_KEY        = 'stabilis_cloudproxy/general/api_key';
    const XML_PATH_SECRET_KEY     = 'stabilis_cloudproxy/general/secret_key';
    const XML_PATH_API_ENDPOINT   = 'stabilis_cloudproxy/internal/api_endpoint';
    const XML_PATH_API_USER_AGENT = 'stabilis_cloudproxy/internal/api_useragent';

    protected function _getVersion() {
        return (string)Mage::getConfig()->getNode('modules/Stabilis_CloudProxy/version');
    }
        
    public function getIsEnabled($storeId = null) {
        return Mage::getStoreConfigFlag(static::XML_PATH_ENABLED, $storeId);
    }
    
    public function getApiEndpoint($storeId = null) {
        if($this->getIsEnabled()) {
            return Mage::getStoreConfig(static::XML_PATH_API_ENDPOINT, $storeId);
        }
        return null;
    }
    
    public function getApiUserAgent($storeId = null) {
        if($this->getIsEnabled()) {
            return sprintf(Mage::getStoreConfig(static::XML_PATH_API_USER_AGENT, $storeId), $this->_getVersion());
        }
        return null;
    }
    
    public function getApiKey($storeId = null) {
        if($this->getIsEnabled()) {
            $helper = Mage::helper('core');
            /* @var $helper Mage_Core_Helper_Data */

            return $helper->decrypt(
                    Mage::getStoreConfig(static::XML_PATH_API_KEY, $storeId));
        }
        return null;
    }
    
    public function getSecretKey($storeId = null) {
        if($this->getIsEnabled()) {
            $helper = Mage::helper('core');
            /* @var $helper Mage_Core_Helper_Data */

            return $helper->decrypt(
                    Mage::getStoreConfig(static::XML_PATH_SECRET_KEY, $storeId));
        }
        return null;
    }
}
