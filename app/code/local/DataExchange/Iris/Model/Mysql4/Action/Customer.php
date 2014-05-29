<?php

class DataExchange_Iris_Model_Mysql4_Action_Customer extends Mage_Core_Model_Mysql4_Abstract {

    public function _construct() {
        $this->_init('iris/action_customer', 'id');
    }

}