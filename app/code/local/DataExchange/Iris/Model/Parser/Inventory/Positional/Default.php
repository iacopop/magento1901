<?php

class DataExchange_Iris_Model_Parser_Inventory_Positional_Default extends DataExchange_Iris_Model_Parser_Inventory_Abstract {

    private $filePath;
    private $ftpHost;
    private $ftpUser;
    private $ftpPass;

    /**
     * TODO: inserire nel costruttore i parametri necessari a prendere i file
     */
    public static function fromLocalFile($filePath) {
        $parser = new DataExchange_Iris_Model_Parser_Inventory_Positional_Default();
        $parser->filePath = $filePath;

        return $parser;
    }

    public static function fromFtpFile($filePath, $ftpHost, $ftpUser, $ftpPass) {
        $parser = new DataExchange_Iris_Model_Parser_Inventory_Positional_Default();
        $parser->filePath = $filePath;
        $parser->ftpHost = $ftpHost;
        $parser->ftpUser = $ftpUser;
        $parser->ftpPass = $ftpPass;

        return $parser;
    }

    /**
     * legge il file csv e ritorna un oggetto 
     */
    public function readData() {
        $returnArray = array();
        $handle = fopen($this->filePath, "r");

        while (($data = fgets($handle)) !== false) {
            $sku = substr(trim(substr($data, 0, 20)), 2, 18);

            $qty = substr($data, 90, 20);

            $curInventory = new DataExchange_Iris_Model_Data_Inventory_Default();
            $curInventory->setIterations(0);
            $curInventory->setQty($qty);
            $curInventory->setSku($sku);
            $curInventory->setSource($this->filePath);
            $curInventory->setStoreId(0);

            $returnArray[] = $curInventory;
        }

        fclose($handle);
        return $returnArray;
    }

}

?>
