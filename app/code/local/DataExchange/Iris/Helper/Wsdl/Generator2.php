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
//
//class SimpleProduct {
//    /** @var String  */
//    public $sku;
//    /** @var String  */
//    public $name;
//    /** @var String  */    
//    public $price;    
//    /** @var Attribute[]  */
//    public $attributeArray = array();    
//}
//
//class ConfigurableProduct {
//    /** @var String  */
//    public $sku;
//    /** @var String  */
//    public $name;
//    /** @var String  */    
//    public $price;    
//    /** @var String  */    
//    public $configurableAttributes;       
//    
//    /** @var Attribute[]  */
//    public $attributeArray = array();    
//    
//    /** @var SimpleProduct[]  */
//    public $simpleProductArray = array();       
//}
//
//
//class Attribute {
//    /** @var String  */ 
//    public $attributeCode;
//    /** @var String  */ 
//    public $attributeValue;
//    /** @var String  */ 
//    public $storeId;
//}
//
//class ExportPrice {
//    /** @var String  */ 
//    public $sku;
//    /** @var String  */ 
//    public $price;
//}
//
//class ExportPrices {
//    /** @var String  */
//    public $result_code;
//    /** @var ExportPrice[]  */
//    public $exportPricesArray = array();       
//}
//
//class Brand {
//    /** @var String  */
//    public $title;    
//    /** @var String  */
//    public $title_eng;
//    /** @var String  */
//    public $description;
//    /** @var String  */
//    public $description_eng;
//    /** @var String  */
//    public $meta_description;
//    /** @var String  */
//    public $meta_description_eng;
//    /** @var String  */
//    public $name;
//    /** @var String  */
//    public $fascia_sconto;
//    /** @var String  */
//    public $immagine;
//}
//
//class OrderExportResult {
//    /** @var String  */ 
//    public $result_code;    
//    /** @var OrderExport[]  */
//    public $orders;   
//}
//
//class OrderExport {    
//    /** @var OrderHeader  */ 
//    public $header;
//    /** @var OrderRow[]  */
//    public $rows;        
//}
//
//class OrderHeader {
//    /** @var String  */
//    public $order_id;
//    /** @var String  */
//    public $order_date;
//    /** @var String  */
//    public $customer_id;
//    /** @var String  */
//    public $customer_email;
//    /** @var String  */
//    public $billing_firstname;
//    /** @var String  */
//    public $billing_lastname;
//    /** @var String  */
//    public $billing_street;
//    /** @var String  */
//    public $billing_co;
//    /** @var String  */
//    public $billing_zipcode;
//    /** @var String  */
//    public $billing_city;
//    /** @var String  */
//    public $billing_region;
//    /** @var String  */
//    public $billing_nation;
//    /** @var String  */
//    public $codice_fiscale;
//    /** @var String  */
//    public $piva;
//    /** @var String  */
//    public $billing_phone;
//    /** @var String  */
//    public $payment_method;
//    /** @var String  */
//    public $shipping_method;
//    /** @var String  */
//    public $shipping_firstname;
//    /** @var String  */
//    public $shipping_lastname;
//    /** @var String  */
//    public $shipping_street;
//    /** @var String  */
//    public $shipping_co;
//    /** @var String  */
//    public $shipping_zipcode;
//    /** @var String  */
//    public $shipping_city;
//    /** @var String  */
//    public $shipping_region;
//    /** @var String  */
//    public $shipping_nation;
//    /** @var String  */
//    public $shipping_phone;
//    /** @var String  */
//    public $currency_code;
//    /** @var String  */
//    public $shipping_cost;
//    /** @var String  */
//    public $order_total;
//}
//
//class OrderRow {
//    /** @var String  */
//    public $order_id;
//    /** @var String  */
//    public $sku;
//    /** @var String  */
//    public $qty;
//    /** @var String  */
//    public $price;            
//}


//class Label {
//
//    /** @var String  */
//    public $sku;
//
//    /** @var String  */
//    public $label;
//
//}
//
//class LabelsUpdate {
//    
//    /** @var Label[]  */
//    public $labels = array();    
//}

class My_SoapServer_Class {
    
 
    
    /**
     * 
     * @param LabelsUpdate $labels
     * @return ReturnObject
     */
    public function updateProductsLabel(LabelsUpdate $labels){
        $result = new ReturnObject();        
        return $result;        
    }    

    /**
     * 
     * @param String $label
     * @return LabelsUpdate
     */
    public function getSkusForLabel(String $label){
        $validArray = array("normal", "new", "promo", "lastminute");
        $labels = new LabelsUpdate();
        return $labels;
                
        
    }
    
       
}


class DataExchange_Iris_Helper_Wsdl_Generator2 {
    public function generateWsdl(){
        $autodiscover = new Zend_Soap_AutoDiscover('Zend_Soap_Wsdl_Strategy_ArrayOfTypeComplex');
        $autodiscover->setClass( 'My_SoapServer_Class' );
        $autodiscover->handle();        
    }
}
?>
