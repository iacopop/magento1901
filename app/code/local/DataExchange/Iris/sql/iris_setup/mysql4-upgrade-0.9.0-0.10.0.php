<?php


$installer = $this;

$installer->startSetup();

$installer->run("
     
    DROP TABLE IF EXISTS {$installer->getTable('iris/action_customer')};
    CREATE TABLE {$installer->getTable('iris/action_customer')} (
      `id` int(11) unsigned NOT NULL auto_increment,
      `action_type` varchar(255) NOT NULL,
      `status` varchar(255) NOT NULL,
      `note` varchar(255),
      `created_at` datetime NOT NULL,
      `updated_at` datetime NOT NULL,
      `source` varchar(255),
      `customer_id` varchar(255),       
      `customer_email` varchar(255) NOT NULL,                 
      `password` varchar(255),          
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
         
");
    
    


$installer->endSetup();
