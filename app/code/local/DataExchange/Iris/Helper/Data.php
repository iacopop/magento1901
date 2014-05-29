<?php

class DataExchange_Iris_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * 
     * @param type $sku
     * @return boolean return true if product already exists, false altrimenti
     */
    public function productExist($sku){
        $productId = Mage::getModel("catalog/product")->getIdBySku($sku);
        
        if($productId){
            return true;
        }
        return false;
    }
    
    
    public function orderHasInvoice($order_increment_id){  
        $invoicePrefix = "F_";
        return file_exists(Mage::getBaseDir().DS.Mage::getStoreConfig("iris_files/settings/invoice_directory").DS.$invoicePrefix.$order_increment_id.".pdf");
    }
}