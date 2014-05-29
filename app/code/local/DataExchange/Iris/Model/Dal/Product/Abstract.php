<?php

abstract class DataExchange_Iris_Model_Dal_Product_Abstract implements DataExchange_Iris_Model_Dal_Product_Interface{
        
    abstract function insertAction(DataExchange_Iris_Model_Data_Product_Default $object);
    
    abstract function updateAction(DataExchange_Iris_Model_Data_Product_Default $object);
    
    abstract function deleteAction(DataExchange_Iris_Model_Data_Product_Default $object);
    
    abstract function cleanAction();


}
?>
