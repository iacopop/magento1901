<?php

$installer = $this;

$installer->startSetup();

$installer->run("
     
    DROP TABLE IF EXISTS {$installer->getTable('iris/action_order')};
    CREATE TABLE {$installer->getTable('iris/action_order')} (
      `id` int(11) unsigned NOT NULL auto_increment,
      `action_type` varchar(255) NOT NULL,
      `status` varchar(255) NOT NULL,
      `note` varchar(255),
      `created_at` datetime NOT NULL,
      `updated_at` datetime NOT NULL,
      `source` varchar(255),
      `increment_id` varchar(255) NOT NULL,
      `order_status` varchar(255) NOT NULL,
      `tracking_code` varchar(255),      
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
    ALTER TABLE `{$installer->getTable('iris/action_order')}` ADD INDEX `IDX_ACTION_INCREMENT_ID` (`increment_id`);
     
");

$installer->endSetup();