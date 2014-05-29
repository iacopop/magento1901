<?php

class DataExchange_Iris_Model_Cron_Observer {

    const DEFAULT_PRODUCT_PARSER_PATH = 'iris_product/settings/default_parser';
    const DEFAULT_PRODUCT_IMPORT_PATH = 'iris_product/settings/path';
    const DEFAULT_PRODUCT_IMPORT_FILE = 'iris_product/settings/file';
    const DEFAULT_PARSER_TYPE_PATH = 'iris_product/settings/type';
    const DEFAULT_PARSER_DIRECTORY_PATH = 'iris_product/settings/directory';

    protected $_activationHelper;

    public function __construct() {
        $this->_activationHelper = Mage::helper('iris/activation');
    }

    protected function _getDefaultProductParser() {
        $parserCode = Mage::getStoreConfig(self::DEFAULT_PRODUCT_PARSER_PATH);

        $parser = Mage::getModel('iris/parser_product_' . $parserCode . '_default');

        if (!$parser)
            throw new Exception("Undefined Parser.");

        $dirPath = Mage::getBaseDir() . DS . 'var' . DS . 'scambiodati' . DS;
        $dirPath .= Mage::getStoreConfig(self::DEFAULT_PRODUCT_IMPORT_PATH) . DS;

        switch (Mage::getStoreConfig(self::DEFAULT_PARSER_TYPE_PATH)) {
            case DataExchange_Iris_Model_Parser_Product_Type::SINGLE_FILE:
                $file = $dirPath . Mage::getStoreConfig(self::DEFAULT_PRODUCT_IMPORT_FILE);
                $parser->setFilePath($file);
                break;

            case DataExchange_Iris_Model_Parser_Product_Type::DIRECTORY_FILES:
                
                $dir = $dirPath . Mage::getStoreConfig(self::DEFAULT_PARSER_DIRECTORY_PATH) . DS;
                $parser->setDirectory($dir);
                break;

            default:
                throw new Exception("No parser type defined");
                break;
        }

        return $parser;
    }
    
    protected function _getDefaultOrderParser(){
        return true;
    }

    public function productCron() {

        if (!$this->_activationHelper->isProductUpdateActive() || !$this->_activationHelper->isProductScheduleActive())
            throw new Exception("Product cron scheduling is disabled. Enable it on system configuration.");

        $parser = $this->_getDefaultProductParser();

        $data = $parser->readData();

        $dalObject = Mage::getModel('iris/dal_product_default');

        foreach ($data as $product) {
            $dalObject->insertData($product);
        }
    }

    public function inventoryCron() {

        if (!$this->_activationHelper->isInventoryUpdateActive() || !$this->_activationHelper->isInventoryScheduleActive())
            throw new Exception("Inventory cron scheduling is disabled. Enable it on system configuration.");

        Mage::log('called inventoryCron');
    }
    
    public function ordersExportCron() {

        if (!$this->_activationHelper->isOrderScheduleActive())
            throw new Exception("Order cron scheduling is disabled. Enable it on system configuration.");
        
        $parser = $this->_getDefaultOrderParser();
        
        //$parser->getOrdersToExportForDal(array('complete'));
        $parser = new DataExchange_Iris_Model_Parser_Order_Default();
        
        $ordersCollection = $parser->getOrdersToExportForDal(array("complete"));


        $dalObject = Mage::getModel('iris/dal_order_default');

        $newStatus = Mage::getStoreConfig("iris_orders/settings/order_status");
        
        foreach ($ordersCollection as $order) {
            $dalObject->insertAction($order);
            if($newStatus){
                $orderModel = Mage::getModel('sales/order')->loadByIncrementId($order->getIncrementId());
                if($orderModel->getId()){
                    $orderModel->setStatus($newStatus);
                    $orderModel->save();                    
                }                               
            }
        }                
        
    }    

}