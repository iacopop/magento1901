<?php

interface DataExchange_Iris_Model_Parser_Product_Interface{
    
    /*
     * legge dati dalla sorgente e li ritorna (file, table, wsdl, xml, soap)
     */
    public function readData();
    

}
?>
