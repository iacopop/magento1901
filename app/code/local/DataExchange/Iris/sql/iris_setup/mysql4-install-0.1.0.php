<?php


$installer = $this;

$installer->startSetup();

$installer->run("
     
    DROP TABLE IF EXISTS {$installer->getTable('iris/action_product')};
    CREATE TABLE {$installer->getTable('iris/action_product')} (
      `id` int(11) unsigned NOT NULL auto_increment,
      `action_type` varchar(255) NOT NULL,
      `status` varchar(255) NOT NULL,
      `note` varchar(255),
      `created_at` datetime NOT NULL,
      `updated_at` datetime NOT NULL,
      `source` varchar(255),
      `product_type` varchar(255) NOT NULL,
      `sku` varchar(255) NOT NULL,
      `parent_sku` varchar(255),
      `configurable_attributes` varchar(255),      
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
    ALTER TABLE `{$installer->getTable('iris/action_product')}` ADD INDEX `IDX_ACTION_SKU` (`sku`);
     
");
    
    

$installer->run("
     
    DROP TABLE IF EXISTS {$installer->getTable('iris/action_product_attribute')};
    CREATE TABLE {$installer->getTable('iris/action_product_attribute')} (
      `id` int(11) unsigned NOT NULL auto_increment,
      `action_id` int(11) unsigned NOT NULL,
      `attribute_code` varchar(255) NOT NULL,
      `type` varchar(255) NOT NULL,
      `value` varchar(255) NOT NULL,      
      `store_id` int(11) unsigned NOT NULL,      
      PRIMARY KEY (`id`),
      CONSTRAINT `FK_ACTION_ID` FOREIGN KEY (`action_id`) REFERENCES `{$installer->getTable('iris/action_product')}` (`id`) ON UPDATE CASCADE ON DELETE CASCADE      
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
    ALTER TABLE `{$installer->getTable('iris/action_product_attribute')}` ADD INDEX `IDX_ACTION_SKU` (`action_id`);
             
");    


$installer->endSetup();