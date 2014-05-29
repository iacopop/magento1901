<?php

abstract class DataExchange_Iris_Model_Parser_Product_Abstract implements DataExchange_Iris_Model_Parser_Product_Interface{
    
    abstract public function readData();
    
    public function utility(){
        return "data utility";
    }    
}

