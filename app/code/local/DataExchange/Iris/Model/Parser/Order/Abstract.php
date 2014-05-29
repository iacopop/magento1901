<?php

abstract class DataExchange_Iris_Model_Parser_Order_Abstract implements DataExchange_Iris_Model_Parser_Order_Interface{
    
    abstract public function getOrdersToExportForDal($statusArray);
}

