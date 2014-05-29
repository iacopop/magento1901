<?php


$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();


$installer->run("
    ALTER TABLE {$installer->getTable('iris/action_product_attribute')} MODIFY value TEXT;
");


$installer->endSetup();
