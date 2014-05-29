<?php

class DataExchange_Iris_Block_Adminhtml_Iris extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {
        $this->_controller = 'adminhtml_iris';
        $this->_blockGroup = 'iris';
        $this->_headerText = Mage::helper('iris')->__('Action Manager');
        $this->_addButtonLabel = Mage::helper('iris')->__('Add Action');
        parent::__construct();
    }

}