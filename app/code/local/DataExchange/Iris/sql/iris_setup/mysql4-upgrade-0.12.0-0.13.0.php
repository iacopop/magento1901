<?php


$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();


$installer->run("
    ALTER TABLE {$installer->getTable('iris/action_order')} ADD COLUMN payment_method varchar(255) after remote_ip;
");


$installer->endSetup();
