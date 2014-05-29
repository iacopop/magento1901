<?php

class DataExchange_Iris_Model_Dal_Customer_Default extends DataExchange_Iris_Model_Dal_Customer_Abstract {
    
    const ACTION_TYPE_INSERT = "insert";
    
    const ACTION_STATUS_TO_BE_PROCESSED = "to_be_processed";        
    const ACTION_STATUS_PROCESSED = "processed";        

    public function insertAction(DataExchange_Iris_Model_Data_Customer_Default $object) {
        Mage::helper("iris/log")->log("New INSERT action for customer: ".$object->getCustomerEmail());
        $insertModelAction = Mage::getModel("iris/action_customer");
        $insertModelAction->setActionType(DataExchange_Iris_Model_Dal_Customer_Default::ACTION_TYPE_INSERT);
        $insertModelAction->setStatus(DataExchange_Iris_Model_Dal_Customer_Default::ACTION_STATUS_TO_BE_PROCESSED);        
        $insertModelAction->setNote("");
        $insertModelAction->setCreatedAt(strtotime('now'));
        $insertModelAction->setSource($object->getSource());
        
        $insertModelAction->setCustomerEmail($object->getCustomerEmail());
        
        //CHECK PASSWORD
        $insertModelAction->setPassword($object->getPassword());
        
        $insertModelAction->setBillingFirstname($object->getBillingFirstname());
        $insertModelAction->setBillingLastname($object->getBillingLastname());
        $insertModelAction->setBillingStreet($object->getBillingStreet());
        $insertModelAction->setBillingCo($object->getBillingCo());
        $insertModelAction->setBillingZipcode($object->getBillingZipcode());
        $insertModelAction->setBillingCity($object->getBillingCity());
        $insertModelAction->setBillingRegion($object->getBillingRegion());
        $insertModelAction->setBillingNation($object->getBillingNation());
        $insertModelAction->setBillingCodiceFiscale($object->getBillingCodiceFiscale());
        $insertModelAction->setBillingVat($object->getBillingVat());
        $insertModelAction->setBillingCompany($object->getBillingCompany());
        $insertModelAction->setBillingPhone($object->getBillingPhone());
        $insertModelAction->setShippingFirstname($object->getShippingFirstname());
        $insertModelAction->setShippingLastname($object->getShippingLastname());
        $insertModelAction->setShippingStreet($object->getShippingStreet());
        $insertModelAction->setShippingCo($object->getShippingCo());
        $insertModelAction->setShippingZipcode($object->getShippingZipcode());
        $insertModelAction->setShippingCity($object->getShippingCity());
        $insertModelAction->setShippingRegion($object->getShippingRegion());
        $insertModelAction->setShippingNation($object->getShippingNation());
        $insertModelAction->setShippingPhone($object->getShippingPhone());
        $insertedModel = $insertModelAction->save();
        return $insertedModel->getId();
                
    }

    
    public function insertData(DataExchange_Iris_Model_Data_Customer_Default $object){                
        return $this->insertAction($object);
    }
}
?>
