<?php

$installer = $this;
$installer->startSetup();
$installer->run(" 
ALTER TABLE `{$installer->getTable('sales/order')}` ADD `is_exported` int NOT NULL DEFAULT 0;
");
$installer->endSetup();