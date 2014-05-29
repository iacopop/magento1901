<?php

class DataExchange_Iris_Model_Consumer_Customer_Venchi_Default extends DataExchange_Iris_Model_Consumer_Customer_Default {

    
    public function consumeCustomer($action_order_id){
        Mage::helper("iris/log")->log("Creazione customer con action id ".$action_order_id);
        $customerAction = Mage::getModel("iris/action_customer")->load($action_order_id);
        
        //store IT = website 1, view 1
        //store EU EN = website 3, view  5
        //store UK = website 2, view  2
        //store RW = website 4, view  3
        //store DE = website 5, view  6
        
        $websiteId = "1";
        $storeId = "1";

        $customer = Mage::getModel("customer/customer");
        $customer->setWebsiteId = $websiteId;
        $customer->setStore(Mage::getModel('core/store')->load($storeId));

        $customer->setFirstname($customerAction->getBillingFirstname());
        $customer->setLastname($customerAction->getBillingLastname());
        $customer->setEmail($customerAction->getCustomerEmail());
        $customer->setPasswordHash($customerAction->getPassword());
        $customer->save();

    }
}

?>
