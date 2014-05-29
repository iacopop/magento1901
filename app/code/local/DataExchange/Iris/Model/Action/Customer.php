<?php

class DataExchange_Iris_Model_Action_Customer extends Mage_Core_Model_Abstract {

    public function _construct() {
        $this->_init('iris/action_customer', 'id');
    }
    
    public function setHasBeenProcessed() {
        $this->setStatus('processed');
        $this->setUpdatedAt(strtotime('now'));
        $this->save();
    }

}

?>
