<?php

$installer = $this;

$installer->startSetup();

$installer->run("
     
    DROP TABLE IF EXISTS {$installer->getTable('iris/action_inventory')};
    CREATE TABLE {$installer->getTable('iris/action_inventory')} (
      `id` int(11) unsigned NOT NULL auto_increment,
      `action_type` varchar(255) NOT NULL,
      `status` varchar(255) NOT NULL,
      `note` varchar(255),
      `created_at` datetime NOT NULL,
      `updated_at` datetime NOT NULL,
      `source` varchar(255),
      `sku` varchar(255) NOT NULL,
      `qty` varchar(255) NOT NULL,
      `iterations` int(11) default 0,      
      `store_id` int(11) default 0,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
    ALTER TABLE `{$installer->getTable('iris/action_inventory')}` ADD INDEX `IDX_ACTION_SKU` (`sku`);
     
");

$installer->endSetup();