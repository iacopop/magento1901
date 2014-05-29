<?php

class DataExchange_Iris_Block_Adminhtml_Inventory_Iris_View extends Mage_Adminhtml_Block_Widget_Container {

    public function __construct() {
        parent::__construct();

        $this->_addButton('back', array(
            'label' => Mage::helper('adminhtml')->__('Back'),
            'onclick' => 'setLocation(\'' . $this->getBackUrl() . '\')',
            'class' => 'back',
                ), -1);
    }

    protected function getInventory() {

        return Mage::getModel('iris/action_inventory')->load($this->getRequest()->getParam('id'));
    }

    public function getBackUrl() {
        return $this->getUrl('*/*/');
    }

    public function getHeaderText() {

        return Mage::helper('iris')->__('History for product %s', $this->getInventory()->getSku());
    }

    public function getInventoryHistory() {
        return Mage::getModel('iris/action_inventory')->getCollection()
                        ->addFieldToFilter('sku', $this->getInventory()->getSku());
    }

}