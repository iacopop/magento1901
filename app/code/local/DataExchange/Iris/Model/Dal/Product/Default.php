<?php

class DataExchange_Iris_Model_Dal_Product_Default extends DataExchange_Iris_Model_Dal_Product_Abstract {
    
    const ACTION_TYPE_INSERT = "insert";
    const ACTION_TYPE_UPDATE = "update";    
    
    const ACTION_STATUS_TO_BE_PROCESSED = "to_be_processed";        
    const ACTION_STATUS_PROCESSED = "processed";        
    
    const ACTION_PRODUCT_VISIBILITY = "4";            
        
    
    
    public function cleanAction() {
        
    }

    public function deleteAction(DataExchange_Iris_Model_Data_Product_Default $object) {
        
    }

    public function insertAction(DataExchange_Iris_Model_Data_Product_Default $object) {
        Mage::helper("iris/log")->log("New INSERT action for sku: ".$object->getSku());
        $insertModelAction = Mage::getModel("iris/action_product");
        $insertModelAction->setActionType(DataExchange_Iris_Model_Dal_Product_Default::ACTION_TYPE_INSERT);
        $insertModelAction->setStatus(DataExchange_Iris_Model_Dal_Product_Default::ACTION_STATUS_TO_BE_PROCESSED);        
        $insertModelAction->setNote("");
        $insertModelAction->setCreatedAt(strtotime('now'));
        $insertModelAction->setSource($object->getSource());
        $insertModelAction->setProductType($object->getProductType());        
        $insertModelAction->setSku($object->getSku());
        $insertModelAction->setProductStatus($object->getProductStatus());
        $name = $object->getName();
        if(!isset($name) || trim($name) == ""){
            throw new Exception("ERROR: nome mancante per sku ".$object->getSku());
            return null;
        }
        $insertModelAction->setName($object->getName());        
        $insertModelAction->setParentSku($object->getParentSku());
        $insertModelAction->setConfigurableAttributes($object->getConfigurableAttributes());
        
        //attributi aggiuntivi
        $insertModelAction->setAttributeSetId($object->getAttributeSetId());
        $insertModelAction->setWebsiteIds($object->getWebsiteIds());
        $insertModelAction->setTaxClass($object->getTaxClass());
        $insertModelAction->setCategoryIds($object->getCategoryIds());
        $insertModelAction->setVisibility($object->getVisibility());
        
        $insertedModel = $insertModelAction->save();
        
        foreach ($object->getAttributesList() as $attribute){
            $insertModelAttributeAction = Mage::getModel("iris/action_product_attribute");
            $insertModelAttributeAction->setActionId($insertedModel->getId());
            $insertModelAttributeAction->setAttributeCode($attribute->getAttributeCode());
            $insertModelAttributeAction->setValue($attribute->getValue());
            $insertModelAttributeAction->setType($attribute->getType());
            $insertModelAttributeAction->setStoreId($attribute->getStoreId());
            $insertModelAttributeAction->save();
        }
        
        return $insertedModel->getId();
                
    }

    /**
     * 
     * @param type $DataExchange_Iris_Model_Data_Product_Attribute_Array array of DataExchange_Iris_Model_Data_Product_Attribute
     */
    public function updateAction(DataExchange_Iris_Model_Data_Product_Default $object) {
        Mage::helper("iris/log")->log("New UPDATE action for sku: ".$object->getSku());
        
    }   
    
    public function insertData(DataExchange_Iris_Model_Data_Product_Default $object){        
        $productSku = $object->getSku();
        
        if(Mage::helper("iris")->productExist($productSku)){            
            return $this->updateAction($object);
        }else{
            //TODO: check se l'azione di insert per questo SKU è giù presente; in caso inviare eccezione
            return $this->insertAction($object);
        }
    }
}
?>
