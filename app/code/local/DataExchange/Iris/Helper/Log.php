<?php

class DataExchange_Iris_Helper_Log extends Mage_Core_Helper_Abstract
{
    /**
     * Log in specific file
     * @param type $message
     */     
    public function log($message, $level = null){
        Mage::log($message, $level, "iris.log");
    }
}
?>
