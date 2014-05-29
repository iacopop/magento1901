<?php

class DataExchange_Iris_Model_Consumer_Order_Default extends DataExchange_Iris_Model_Consumer_Order_Abstract {

    /**
     * La logica di questa classe è legata al consumer.
     * Se pur questa classe esporta ordini è da considerarsi un CONSUMER, perchè interviene dopo che il DAL ha scritto.
     */
    
    private $exportDirectory;

    function __construct($exportDirectory) {
        $this->exportDirectory = $exportDirectory;
    }    

    public function consumeRows() {
     
    }
    
    public function consumeOrder($action_order_id){
        Mage::helper("iris/log")->log("Consumer di default! Questo consumer ordini non fa nulla, scegliere quello corretto in amministrazione!");
        return null;
    }
}

?>
