<?php

class DataExchange_Iris_Model_Action_Product extends Mage_Core_Model_Abstract {

    public function _construct() {
        $this->_init('iris/action_product', 'id');
    }

    public function getAttributesCollection() {
        return Mage::getModel("iris/action_product_attribute")->getCollection()
                        ->addFieldToFilter("action_id", $this->getId());
    }

    public function setHasBeenProcessed() {
        $this->setStatus('processed');
        $this->setUpdatedAt(strtotime('now'));
        $this->save();
    }

    public function setNeedToBeProcessedForConfigurable() {
        $this->setStatus('processing_for_configurable');
        $this->setUpdatedAt(strtotime('now'));
        $this->save();
    }

}

?>
