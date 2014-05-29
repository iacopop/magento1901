<?php

class DataExchange_Iris_Model_Action_Inventory extends Mage_Core_Model_Abstract {

    public function _construct() {
        $this->_init('iris/action_inventory', 'id');
    }

    public function loadBySku($sku) {
        return $this->load($sku, 'sku');
    }

}

?>
