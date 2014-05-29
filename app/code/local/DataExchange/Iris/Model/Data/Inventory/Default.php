<?php

/**
 * Questa class è l'oggetto Prodotto che viene ritornato dal parser
 */
class DataExchange_Iris_Model_Data_Inventory_Default {

    private $sku;
    private $source;
    private $qty;
    private $iterations;
    private $store_id;

    /**
     * NOTA: questa classe deve avere delle variabili che sono i dati necessari alla creazione di un prodotto.
     * Esempio di funzioni: getSku(), getName(), getDescription(), getWeight()
     * 
     */
    public function __construct() {
        
    }

    public function getSku() {
        return $this->sku;
    }

    public function setSku($sku) {
        $this->sku = $sku;
    }

    public function getSource() {
        return $this->source;
    }

    public function setSource($source) {
        $this->source = $source;
    }

    public function getQty() {
        return $this->qty;
    }

    public function setQty($qty) {
        $this->qty = $qty;
    }

    public function getIterations() {
        return $this->iterations;
    }

    public function setIterations($iterations) {
        $this->iterations = $iterations;
    }

    public function getStoreId() {
        return $this->store_id;
    }

    public function setStoreId($store_id) {
        $this->store_id = $store_id;
    }

}

?>
