<?php


$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();


$installer->run("
    ALTER TABLE {$installer->getTable('iris/action_product')} ADD COLUMN product_status int(11) default 1;
");


$installer->endSetup();
