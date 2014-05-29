<?php

class DataExchange_Iris_Model_Parser_Product_Csv_Default extends DataExchange_Iris_Model_Parser_Product_Abstract {

    private $filePath;
    private $ftpHost;
    private $ftpUser;
    private $ftpPass;
    private $directory;

    /**
     * TODO: inserire nel costruttore i parametri necessari a prendere i file
     */
    public static function fromLocalFile($filePath) {
        $parser = new DataExchange_Iris_Model_Parser_Product_Csv_Default();
        $parser->filePath = $filePath;

        return $parser;
    }

    public function setFilePath($filePath) {
        $this->filePath = $filePath;
        return $this;
    }

    public function setDirectory($dir) {
        $this->directory = $dir;
        return $this;
    }

    public static function fromFtpFile($filePath, $ftpHost, $ftpUser, $ftpPass) {
        $parser = new DataExchange_Iris_Model_Parser_Product_Csv_Default();
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
        $files = $this->_getFilesToBeProcessed();

        foreach ($files as $file) {
            $handle = fopen($file, "r");
            while (($data = fgetcsv($handle, 0, ';', '"')) !== false) {
                //inizio il parsing

                $curProduct = new DataExchange_Iris_Model_Data_Product_Default();
                $curProduct->setSku($data[0]);
                $curProduct->setSource($this->filePath);
                $curProduct->setProductType(Mage_Catalog_Model_Product_Type::TYPE_SIMPLE);

                $curProduct->setAttributeSetId(DataExchange_Iris_Model_Data_Product_Default::ATTRIBUTE_SET_ID_DEFAULT);
                //$curProduct->setWebsiteIds(DataExchange_Iris_Model_Data_Product_Default::WEBSITE_IDS_DEFAULT);
                $curProduct->setWebsiteIds("1,2,3,4");
                $curProduct->setTaxClass(DataExchange_Iris_Model_Data_Product_Default::TAX_CLASS_DEFAULT);
                $curProduct->setVisibility(DataExchange_Iris_Model_Data_Product_Default::VISIBILITY_DEFAULT);
                $curProduct->setProductStatus(DataExchange_Iris_Model_Data_Product_Default::STATUS_ENABLED);

                //NAME: questo è un esempio di setting del nome della linga di default (scope globale, perchè non gli passo storeview, ovvero store_view = 0)
                $name = new DataExchange_Iris_Model_Data_Product_Attribute("name", "text", $data[1]);
                $curProduct->addAttribute($name);
                $nameENG = new DataExchange_Iris_Model_Data_Product_Attribute("name", "text", $data[9], 5);
                $curProduct->addAttribute($nameENG);
                $nameENG = new DataExchange_Iris_Model_Data_Product_Attribute("name", "text", $data[9], 3);
                $curProduct->addAttribute($nameENG);
                $nameENG = new DataExchange_Iris_Model_Data_Product_Attribute("name", "text", $data[9], 2);
                $curProduct->addAttribute($nameENG);
                $nameDE = new DataExchange_Iris_Model_Data_Product_Attribute("name", "text", $data[11], 4);
                $curProduct->addAttribute($nameDE);

                //WEIGHT
                $weight = new DataExchange_Iris_Model_Data_Product_Attribute("weight", "text", $data[4]);
                $curProduct->addAttribute($weight);

                //PREZZO
                $price = new DataExchange_Iris_Model_Data_Product_Attribute("price", "price", $data[5]);
                $curProduct->addAttribute($price);
                $priceEU = new DataExchange_Iris_Model_Data_Product_Attribute("price", "price", $data[6], 4);
                $curProduct->addAttribute($priceEU);
                $priceRW = new DataExchange_Iris_Model_Data_Product_Attribute("price", "price", $data[7], 3);
                $curProduct->addAttribute($priceRW);
                $priceUK = new DataExchange_Iris_Model_Data_Product_Attribute("price", "price", $data[8], 2);
                $curProduct->addAttribute($priceUK);

                //DESCRIZIONE
                $descrizione = new DataExchange_Iris_Model_Data_Product_Attribute("description", "text", $data[13]);
                $curProduct->addAttribute($descrizione);
                $descrizioneENG = new DataExchange_Iris_Model_Data_Product_Attribute("description", "textarea", $data[12], 2);
                $curProduct->addAttribute($descrizioneENG);
                $descrizioneENG = new DataExchange_Iris_Model_Data_Product_Attribute("description", "textarea", $data[12], 3);
                $curProduct->addAttribute($descrizioneENG);
                $descrizioneENG = new DataExchange_Iris_Model_Data_Product_Attribute("description", "textarea", $data[12], 5);
                $curProduct->addAttribute($descrizioneENG);
                $descrizioneDE = new DataExchange_Iris_Model_Data_Product_Attribute("description", "textarea", $data[14], 4);
                $curProduct->addAttribute($descrizioneDE);

                //TIPOLOGIA CIOCCOLATO (FONDENTE) - 15
                $tipologia_cioccolato = new DataExchange_Iris_Model_Data_Product_Attribute("tipologia_cioccolato", "select", $data[15]);
                $curProduct->addAttribute($tipologia_cioccolato);

                //TIPOLOGIA CONFEZIONE (FONDENTE) - 16
                $tipologia_confezione = new DataExchange_Iris_Model_Data_Product_Attribute("tipologia_confezione", "select", $data[16]);
                $curProduct->addAttribute($tipologia_confezione);

                //IDEE REGALO - 18
                $idee_regalo = new DataExchange_Iris_Model_Data_Product_Attribute("idee_regalo", "multiselect", $data[18]);
                $curProduct->addAttribute($idee_regalo);

                //COLLEZIONI - 19
                $collezioni = new DataExchange_Iris_Model_Data_Product_Attribute("collezioni", "select", $data[19]);
                $curProduct->addAttribute($collezioni);

                //TIPOLOGIE PRODOTTI - 21
                $tipologie_prodotti = new DataExchange_Iris_Model_Data_Product_Attribute("tipologie_prodotti", "select", $data[21]);
                $curProduct->addAttribute($tipologie_prodotti);

                //INGREDIENTI - 22
                $ingredienti = new DataExchange_Iris_Model_Data_Product_Attribute("ingredienti", "text", $data[22]);
                $curProduct->addAttribute($ingredienti);

                //VALORI NUTRIZIONALI - 23
                $valori_nutrizionali = new DataExchange_Iris_Model_Data_Product_Attribute("valori_nutrizionali", "text", $data[23]);
                $curProduct->addAttribute($valori_nutrizionali);

                $returnArray[] = $curProduct;
            }
            fclose($handle);
        }
        return $returnArray;
    }

    protected function _getFilesToBeProcessed() {
        $files = array();

        if ($this->filePath)
            $files[] = $this->filePath;

        if ($this->directory) {
            foreach (scandir($this->directory) as $file) {
                if (is_file($this->directory . $file) && filesize($this->directory . $file) > 0)
                    $files[] = $this->directory . $file;
            }
        }

        return $files;
    }

}

?>
