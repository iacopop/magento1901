<?php

interface DataExchange_Iris_Model_Dal_Inventory_Interface {
    
    public function insertAction(DataExchange_Iris_Model_Data_Inventory_Default $object);
    
    public function updateAction(DataExchange_Iris_Model_Data_Inventory_Default $object);
    
    public function deleteAction(DataExchange_Iris_Model_Data_Inventory_Default $object);
    
    public function cleanAction();
        
    
}
?>
