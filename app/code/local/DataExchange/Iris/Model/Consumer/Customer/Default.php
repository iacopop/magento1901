<?php

class DataExchange_Iris_Model_Consumer_Customer_Default extends DataExchange_Iris_Model_Consumer_Customer_Abstract {


    public function consumeRows() {
        //prendo tutte le righe ancora da processare ordinate in modo crescente
        $collection = Mage::getModel("iris/action_customer")->getCollection()
                ->addFieldToFilter('status', DataExchange_Iris_Model_Dal_Customer_Default::ACTION_STATUS_TO_BE_PROCESSED)
                ->setOrder("id", Varien_Data_Collection::SORT_ORDER_ASC);

        //Consumo le righe ordine per l'export

        foreach ($collection as $action) {
            if ($action->getActionType() == DataExchange_Iris_Model_Dal_Order_Default::ACTION_TYPE_INSERT) {
                $this->consumeCustomer($action->getId());
                $action->setHasBeenProcessed();
            } else {
                Mage::helper("iris/log")->log("Azione per ordine non implementata");
            }
        }        
    }
    
    public function consumeCustomer($action_order_id){
        Mage::helper("iris/log")->log("Creazione customer con action id ".$action_order_id);
        $websiteId = Mage::app()->getWebsite()->getId();
        $store = Mage::app()->getStore();

        $customer = Mage::getModel("customer/customer");
        $customer->setWebsiteId = $websiteId;
        $customer->setStore($store);

        $customer->setFirstname("Douglas");
        $customer->setLastname("Radburn");
        $customer->setEmail("hello@douglasradburn.co.uk");
        $customer->setPasswordHash(md5("myReallySecurePassword"));
        $customer->save();


        $address = Mage::getModel("customer/address");
// you need a customer object here, or simply the ID as a string.
        $address->setCustomerId($customer->getId());
        $address->setFirstname($customer->getFirstname());
        $address->setLastname($customer->getLastname());
        $address->setCountryId("GB"); //Country code here
        $address->setStreet("A Street");
        $address->setPostcode("LS253DP");
        $address->setCity("Leeds");
        $address->setTelephone("07789 123 456");

        $address->save();
    }
}

?>
