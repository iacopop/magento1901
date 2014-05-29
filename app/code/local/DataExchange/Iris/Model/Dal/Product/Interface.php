<?php

interface DataExchange_Iris_Model_Dal_Product_Interface {
    
    public function insertAction(DataExchange_Iris_Model_Data_Product_Default $object);
    
    public function updateAction(DataExchange_Iris_Model_Data_Product_Default $object);
    
    public function deleteAction(DataExchange_Iris_Model_Data_Product_Default $object);
    
    public function cleanAction();
        
    
}
?>
