<?php

abstract class DataExchange_Iris_Model_Dal_Inventory_Abstract implements DataExchange_Iris_Model_Dal_Inventory_Interface{
        
    abstract function insertAction(DataExchange_Iris_Model_Data_Inventory_Default $object);
    
    abstract function updateAction(DataExchange_Iris_Model_Data_Inventory_Default $object);
    
    abstract function deleteAction(DataExchange_Iris_Model_Data_Inventory_Default $object);
    
    abstract function cleanAction();


}
?>
