<?php

class DataExchange_Iris_Helper_Transaction extends Mage_Core_Helper_Abstract{
    
    public static function saveObjectTransaction($objectModel){
        $transactionSave = Mage::getModel('core/resource_transaction');
        $transactionSave->addObject($objectModel);
        $transactionSave->save();        
        return $objectModel;
    }  
}
?>
