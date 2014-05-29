<?php


$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();


$installer->run("
    ALTER TABLE {$installer->getTable('iris/action_product')} ADD COLUMN attribute_set_id varchar(255) NOT NULL;
    ALTER TABLE {$installer->getTable('iris/action_product')} ADD COLUMN website_ids varchar(255) NOT NULL;
    ALTER TABLE {$installer->getTable('iris/action_product')} ADD COLUMN tax_class int(11) default 2;
    ALTER TABLE {$installer->getTable('iris/action_product')} ADD COLUMN category_ids varchar(255);
    ALTER TABLE {$installer->getTable('iris/action_product')} ADD COLUMN visibility int(11) NOT NULL;
");


$installer->endSetup();
