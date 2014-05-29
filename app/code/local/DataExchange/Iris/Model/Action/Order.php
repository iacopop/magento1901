<?php

class DataExchange_Iris_Model_Action_Order extends Mage_Core_Model_Abstract {

    public function _construct() {
        $this->_init('iris/action_order', 'id');
    }
    
    public function getRowsCollection() {
        return Mage::getModel("iris/action_order_rows")->getCollection()
                        ->addFieldToFilter("action_order_id", $this->getId());
    }   
    
    public function setHasBeenProcessed() {
        $this->setStatus('processed');
        $this->setUpdatedAt(strtotime('now'));
        $this->save();
    }

}

?>
