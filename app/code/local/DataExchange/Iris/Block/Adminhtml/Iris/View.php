<?php

class DataExchange_Iris_Block_Adminhtml_Iris_View extends Mage_Adminhtml_Block_Widget_Container {

    public function __construct() {
        parent::__construct();

        $this->_addButton('back', array(
            'label' => Mage::helper('adminhtml')->__('Back'),
            'onclick' => 'setLocation(\'' . $this->getBackUrl() . '\')',
            'class' => 'back',
                ), -1);
    }

    protected function getIris() {

        return Mage::getModel('iris/action_product')->load($this->getRequest()->getParam('id'));
    }

    protected function getStoresFromAttributes() {
        $attributes = $this->getIris()->getAttributesCollection();

        $stores = array();

        foreach ($attributes as $a)
            $stores[$a->getStoreId()] = $a->getStoreId();

        ksort($stores);

        return $stores;
    }

    protected function getAttributesByCode() {
        $attributes = $this->getIris()->getAttributesCollection();

        $arrayAttributes = array();

        foreach ($attributes as $a)
            $arrayAttributes[$a->getAttributeCode()][$a->getStoreId()] = $a;

        return $arrayAttributes;
    }

    public function getBackUrl() {
        return $this->getUrl('*/*/');
    }

    public function getHeaderText() {

        return Mage::helper('iris')->__('Attributes for Action # %s', $this->getIris()->getId());
    }

    public function getInventoryHistoryBySku($sku) {
        return Mage::getModel('iris/action_inventory')->getCollection()
                        ->addFieldToFilter('sku', $sku);
    }

}