<?php

class DataExchange_Iris_Model_Mysql4_Action_Inventory_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

    public function _construct() {

        $this->_init('iris/action_inventory');
    }

}