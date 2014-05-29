<?php

class DataExchange_Iris_Helper_Activation extends Mage_Core_Helper_Abstract {

    const INVENTORY_UPDATE_PATH = 'iris_activation/inventory/active';
    const INVENTORY_SCHEDULE_PATH = 'iris_activation/inventory/active_schedule';
    const PRODUCT_UPDATE_PATH = 'iris_activation/product/active';
    const PRODUCT_SCHEDULE_PATH = 'iris_activation/product/active_schedule';
    const ORDER_SCHEDULE_PATH = 'iris_activation/order/active_schedule';

    public function isInventoryUpdateActive() {
        return Mage::getStoreConfig(self::INVENTORY_UPDATE_PATH);
    }

    public function isInventoryScheduleActive() {
        return Mage::getStoreConfig(self::INVENTORY_SCHEDULE_PATH);
    }

    public function isProductUpdateActive() {
        return Mage::getStoreConfig(self::PRODUCT_UPDATE_PATH);
    }

    public function isProductScheduleActive() {
        return Mage::getStoreConfig(self::PRODUCT_SCHEDULE_PATH);
    }
    
    public function isOrderScheduleActive() {
        return true;
        //return Mage::getStoreConfig(self::ORDER_SCHEDULE_PATH);
    }    

}