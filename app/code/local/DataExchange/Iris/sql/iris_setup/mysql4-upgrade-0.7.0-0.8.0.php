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
      `coupon_code` varchar(255),      
      `shipping_description` varchar(255),      
      `store_id` varchar(255),      
      `base_discount_amount` decimal(12,4),      
      `base_grand_total` decimal(12,4),  
      `base_shipping_amount` decimal(12,4), 
      `base_shipping_tax_amount` decimal(12,4),
      `base_subtotal` decimal(12,4),   
      `base_tax_amount` decimal(12,4),   
      `base_to_global_rate` decimal(12,4),     
      `base_to_order_rate` decimal(12,4),
      `discount_amount` decimal(12,4),   
      `grand_total` decimal(12,4),
      `shipping_amount` decimal(12,4),
      `shipping_tax_amount` decimal(12,4),
      `subtotal` decimal(12,4),
      `tax_amount` decimal(12,4),
      `total_qty_ordered` decimal(12,4),
      `base_subtotal_incl_tax` decimal(12,4),
      `subtotal_incl_tax` decimal(12,4),
      `base_currency_code` varchar(255),      
      `global_currency_code` varchar(255),      
      `order_currency_code` varchar(255), 
      `remote_ip` varchar(255),      
      `shipping_method` varchar(255),      
      `order_created_at` varchar(255),      
      `total_item_count` decimal(12,4),
      `shipping_incl_tax` decimal(12,4),
      `base_shipping_incl_tax` decimal(12,4),
      `customer_id` varchar(255),   
      `customer_email` varchar(255),      
      `billing_firstname` varchar(255),      
      `billing_lastname` varchar(255),      
      `billing_street` varchar(255),      
      `billing_co` varchar(255),      
      `billing_zipcode` varchar(255),      
      `billing_city` varchar(255),         
      `billing_region` varchar(255),      
      `billing_nation` varchar(255),      
      `billing_codice_fiscale` varchar(255),      
      `billing_vat` varchar(255),      
      `billing_company` varchar(255),      
      `billing_phone` varchar(255),      
      `shipping_firstname` varchar(255),         
      `shipping_lastname` varchar(255),      
      `shipping_street` varchar(255),      
      `shipping_co` varchar(255),      
      `shipping_zipcode` varchar(255),      
      `shipping_city` varchar(255),      
      `shipping_region` varchar(255),      
      `shipping_nation` varchar(255),    
      `shipping_phone` varchar(255),             
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
    ALTER TABLE `{$installer->getTable('iris/action_order')}` ADD INDEX `IDX_ACTION_INCREMENT_ID` (`increment_id`);
     
");
    
$installer->run("
     
    DROP TABLE IF EXISTS {$installer->getTable('iris/action_order_rows')};
    CREATE TABLE {$installer->getTable('iris/action_order_rows')} (
      `id` int(11) unsigned NOT NULL auto_increment,
      `action_order_id` int(11) unsigned NOT NULL,
      `product_id` varchar(255), 
      `product_type` varchar(255),  
      `weight` varchar(255),  
      `is_virtual` varchar(255),  
      `sku` varchar(255),  
      `name` varchar(255),  
      `qty_ordered` decimal(12,4),   
      `base_cost` decimal(12,4),
      `price` decimal(12,4),
      `base_price` decimal(12,4), 
      `original_price` decimal(12,4),
      `base_original_price`decimal(12,4),
      `tax_percent` decimal(12,4),
      `tax_amount` decimal(12,4),
      `base_tax_amount` decimal(12,4),
      `discount_amount` decimal(12,4),
      `base_discount_amount` decimal(12,4),
      `row_total` decimal(12,4),
      `base_row_total` decimal(12,4),
      `row_weight` decimal(12,4),
      `base_tax_before_discount` decimal(12,4),
      `tax_before_discount` decimal(12,4),
      `price_incl_tax` decimal(12,4),
      `base_price_incl_tax` decimal(12,4),
      `row_total_incl_tax` decimal(12,4),
      `base_row_total_incl_tax` decimal(12,4),
      PRIMARY KEY (`id`),
      CONSTRAINT `FK_ACTION_ORDER_ID` FOREIGN KEY (`action_order_id`) REFERENCES `{$installer->getTable('iris/action_order')}` (`id`) ON UPDATE CASCADE ON DELETE CASCADE            
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
         
");    


$installer->endSetup();