<?php

class DataExchange_Iris_Model_Data_Product_Attribute {

    private $attribute_code;
    private $type;
    private $value;
    private $store_id;
    
    public function getAttributeCode() {
        return $this->attribute_code;
    }

    public function setAttributeCode($attribute_code) {
        $this->attribute_code = $attribute_code;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = trim($value);
    }

    public function getStoreId() {
        return $this->store_id;
    }

    public function setStoreId($store_id) {
        $this->store_id = $store_id;
    }

        
    /**
     * 
     * @param type $attribute_code codice attributo
     * @param type $type tipo attributo
     * @param type $value valore attributo
     * @param type $store_view_id Codice store view nel quale quell'attributo deve essere aggiornato, se null significa che è globale
     */
    public function __construct($attribute_code, $type, $value, $store_view_id = 0){
        $this->attribute_code = $attribute_code;
        $this->type = $type;
        $this->value = trim($value);
        $this->store_id = $store_view_id;        
    }
}
?>
