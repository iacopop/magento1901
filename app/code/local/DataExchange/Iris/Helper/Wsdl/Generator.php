<?php

/**
 * Questa classe serve solamente come supporto per la generazione dei wsdl.
 * La difficoltà nel generare un wsdl è generare i paramentri di input e di output; questa classe permette di creare oggetti e dinamicamente tirare fuori il wsdl
 * 
 * Ecco un esempio di generazione:  Mage::helper("iris/wsdl_generator")->generateWsdl();
 */

class ReturnObject{
    public $result_code;
    public $result_data = array();    
}

class SimpleProduct {
    /** @var String  */
    public $sku;
    /** @var String  */
    public $name;
    /** @var String  */    
    public $price;    
    /** @var Attribute[]  */
    public $attributeArray = array();    
}

class ConfigurableProduct {
    /** @var String  */
    public $sku;
    /** @var String  */
    public $name;
    /** @var String  */    
    public $price;    
    /** @var String  */    
    public $configurableAttributes;       
    
    /** @var Attribute[]  */
    public $attributeArray = array();    
    
    /** @var SimpleProduct[]  */
    public $simpleProductArray = array();       
}


class Attribute {
    /** @var String  */ 
    public $attributeCode;
    /** @var String  */ 
    public $attributeValue;
    /** @var String  */ 
    public $storeId;
}


class My_SoapServer_Class {
        
    /**
     * 
     * @param SimpleProduct $simple
     * @return ReturnObject
     */
    public function importSimpleProduct(SimpleProduct $simple){

        $result = new ReturnObject();        
        return $result;
    }
    
    /**
     * 
     * @param ConfigurableProduct $configurable
     * @return ReturnObject
     */
    public function importConfigurableProduct(ConfigurableProduct $configurable){

        $result = new ReturnObject();        
        return $result;
    }    
   
    
       
}


class DataExchange_Iris_Helper_Wsdl_Generator {
    public function generateWsdl(){
        $autodiscover = new Zend_Soap_AutoDiscover('Zend_Soap_Wsdl_Strategy_ArrayOfTypeComplex');
        $autodiscover->setClass( 'My_SoapServer_Class' );
        $autodiscover->handle();        
    }
}
?>
