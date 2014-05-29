<?php

class DataExchange_Iris_Block_Iris extends Mage_Core_Block_Template {

    public function _prepareLayout() {
        return parent::_prepareLayout();
    }

    public function getIris() {
        if (!$this->hasData('iris')) {
            $this->setData('iris', Mage::registry('iris'));
        }
        return $this->getData('iris');
    }

}