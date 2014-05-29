<?php


$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();


$installer->run("
    ALTER TABLE {$installer->getTable('iris/action_order')} ADD COLUMN billing_address_id varchar(255) after customer_email;
    ALTER TABLE {$installer->getTable('iris/action_order')} ADD COLUMN shipping_address_id varchar(255) after billing_phone;
");


$installer->endSetup();
