<?php

class DataExchange_Iris_Model_Validator_Product_Default extends DataExchange_Iris_Model_Validator_Product_Abstract {
    
    /**
     * Controlla se l'oggetto prodotto in input è valido e può essere scritto in DAL
     * @param DataExchange_Iris_Model_Data_Product_Default $object
     * @return boolean True se i dati sono validi e possono essere inseriti in DAL, false altrimenti
     */
    public function validateData(DataExchange_Iris_Model_Data_Product_Default $object) {
        return false;
    } 
}
?>
