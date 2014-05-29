<?php

class DataExchange_Iris_Model_Dal_Inventory_Default extends DataExchange_Iris_Model_Dal_Inventory_Abstract {

    const ACTION_TYPE_INSERT = "insert";
    const ACTION_TYPE_UPDATE = "update";
    const ACTION_STATUS_TO_BE_PROCESSED = "to_be_processed";
    const ACTION_STATUS_PROCESSED = "processed";

    public function cleanAction() {
        
    }

    public function deleteAction(DataExchange_Iris_Model_Data_Inventory_Default $object) {
        
    }

    public function insertAction(DataExchange_Iris_Model_Data_Inventory_Default $object) {
        $insertModelAction = Mage::getModel("iris/action_inventory");
        $insertModelAction->setActionType(DataExchange_Iris_Model_Dal_Inventory_Default::ACTION_TYPE_INSERT);
        $insertModelAction->setStatus(DataExchange_Iris_Model_Dal_Inventory_Default::ACTION_STATUS_TO_BE_PROCESSED);
        $insertModelAction->setNote("");
        $insertModelAction->setCreatedAt(strtotime('now'));
        $insertModelAction->setSource($object->getSource());
        $insertModelAction->setSku($object->getSku());
        $insertModelAction->setQty($object->getQty());
        $insertModelAction->setIterations($object->getIterations());
        $insertModelAction->setStoreId($object->getStoreId());

        $insertedModel = $insertModelAction->save();

        return $insertedModel->getId();
    }

    /**
     * 
     * @param type $DataExchange_Iris_Model_Data_Product_Attribute_Array array of DataExchange_Iris_Model_Data_Product_Attribute
     */
    public function updateAction(DataExchange_Iris_Model_Data_Inventory_Default $object) {
        
    }

    public function insertData(DataExchange_Iris_Model_Data_Inventory_Default $object) {
        //$productSku = $object->getSku();
//        if(Mage::helper("iris")->productExist($productSku)){
//            return $this->updateAction($object);
//        }else{
        //TODO: check se l'azione di insert per questo SKU è giù presente; in caso inviare eccezione
        return $this->insertAction($object);
        //}
    }

}

?>
