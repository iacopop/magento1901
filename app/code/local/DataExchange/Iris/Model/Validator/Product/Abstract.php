<?php

abstract class DataExchange_Iris_Model_Validator_Product_Abstract implements DataExchange_Iris_Model_Validator_Product_Interface{
    
    abstract public function validateData(DataExchange_Iris_Model_Data_Product_Default $object);
    
    public function utility(){
        return "data utility";
    }    
}

