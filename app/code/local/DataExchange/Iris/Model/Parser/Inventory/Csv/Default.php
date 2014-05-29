<?php

class DataExchange_Iris_Model_Parser_Inventory_Csv_Default extends DataExchange_Iris_Model_Parser_Inventory_Abstract {

    private $filePath;
    private $ftpHost;
    private $ftpUser;
    private $ftpPass;

    /**
     * TODO: inserire nel costruttore i parametri necessari a prendere i file
     */
    public static function fromLocalFile($filePath) {
        $parser = new DataExchange_Iris_Model_Parser_Inventory_Csv_Default();
        $parser->filePath = $filePath;

        return $parser;
    }

    public static function fromFtpFile($filePath, $ftpHost, $ftpUser, $ftpPass) {
        $parser = new DataExchange_Iris_Model_Parser_Inventory_Csv_Default();
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
        while (($data = fgetcsv($handle, 0, ';', '"')) !== false) {
            //inizio il parsing

            $curProduct = new DataExchange_Iris_Model_Data_Product_Default();
            $curProduct->setSku($data[0]);
            $curProduct->setSource($this->filePath);
            $curProduct->setProductType(Mage_Catalog_Model_Product_Type::TYPE_SIMPLE);

            //NAME: questo è un esempio di setting del nome della linga di default (scope globale, perchè non gli passo storeview, ovvero store_view = 0)
            $name = new DataExchange_Iris_Model_Data_Product_Attribute("name", "text", $data[1]);
            $curProduct->addAttribute($name);

            //NAME: questo è un esempio di setting del nome della linga di default (scope globale, perchè non gli passo storeview, ovvero store_view = 0)
            $nameEng = new DataExchange_Iris_Model_Data_Product_Attribute("name", "text", $data[9], 2);
            $curProduct->addAttribute($nameEng);

            //WEIGHT
            $weight = new DataExchange_Iris_Model_Data_Product_Attribute("weight", "text", $data[4]);
            $curProduct->addAttribute($weight);

            $returnArray[] = $curProduct;
        }
        fclose($handle);
        return $returnArray;
    }

}

?>
