<?php

$installer = $this;
$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$setup->addAttribute('customer', 'is_first_login', array(
    'label' => 'Is first login',
    'type' => 'int',
    'input' => 'text',
    'visible' => false,
    'required' => false,
    'position' => 90,
));

$eavConfig = Mage::getSingleton('eav/config');
$attribute = $eavConfig->getAttribute('customer', 'is_first_login');
$attribute->setData('used_in_forms', array('adminhtml_customer', 'customer_account_create', 'customer_account_edit'));

$attribute->save();

$installer->endSetup();
