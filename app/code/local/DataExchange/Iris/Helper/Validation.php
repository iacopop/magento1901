<?php

class DataExchange_Iris_Helper_Validation extends Mage_Core_Helper_Abstract
{
    /**
     * Valida l'input passato
     * @param type $data è il valore del campo
     * @param type $type può essere di vari tipo: 
     * date, altri da definire
     */
    public function validateInput($data, $type){        
        $typesArray = array("date");
        if(!in_array($type, $typesArray)){
            return false;
        }
        
        switch ($type) {
            case "date":
                $validator = new Zend_Validate_Date(array('format' => 'yyyy-MM-dd H:i:s'));
                if ($validator->isValid($data)) {
                    return true;
                }else{
                    Mage::helper("iris/log")->log("Validation date failed: ".$data." - ".$type, Zend_Log::ERR);
                    return false;
                }
                break;
            default:
                break;
        }
        
        return false;
        


    }
}
?>
