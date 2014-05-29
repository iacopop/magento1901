<?php

abstract class DataExchange_Iris_Model_Parser_Inventory_Abstract implements DataExchange_Iris_Model_Parser_Inventory_Interface{
    
    abstract public function readData();
    
    public function utility(){
        return "data utility";
    }    
}

