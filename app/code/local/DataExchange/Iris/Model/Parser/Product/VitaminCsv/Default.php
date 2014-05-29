<?php

class DataExchange_Iris_Model_Parser_Product_VitaminCsv_Default extends DataExchange_Iris_Model_Parser_Product_Csv_Default {

    private $filePath;
    private $ftpHost;
    private $ftpUser;
    private $ftpPass;
    private $directory;

    /**
     * TODO: inserire nel costruttore i parametri necessari a prendere i file
     */
    public static function fromLocalFile($filePath) {
        $parser = new DataExchange_Iris_Model_Parser_Product_VenchiCsv_Default();
        $parser->filePath = $filePath;

        return $parser;
    }

    public function setFilePath($filePath) {
        $this->filePath = $filePath;
        return $this;
    }

    public static function fromFtpFile($filePath, $ftpHost, $ftpUser, $ftpPass) {
        $parser = new DataExchange_Iris_Model_Parser_Product_VenchiCsv_Default();
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
        $count = 0;
        foreach ($files as $file) {
            $handle = fopen($file, "r");
            while (($data = fgetcsv($handle, 0, '|', '#')) !== false) {

                //ecco le viste:
                //IT = 1
                //B2C IT = 2
                //EN = 3
                //B2C EN = 4
                //inizio il parsing
                $curProduct = new DataExchange_Iris_Model_Data_Product_Default();
                $curProduct->setSku($data[0]);
                $curProduct->setName($data[11]);
                $curProduct->setSource($this->filePath);
                $curProduct->setProductType(Mage_Catalog_Model_Product_Type::TYPE_SIMPLE);

                $curProduct->setAttributeSetId(DataExchange_Iris_Model_Data_Product_Default::ATTRIBUTE_SET_ID_DEFAULT);
                $curProduct->setWebsiteIds("1,2");

                // visibility = 1 non visibile individualmente
                // visibility = 4 visibile catalogo e ricerca
                if ($data[0] == $data[1])
                    $curProduct->setVisibility(4);

                //taxClass
                //21 id 2
                //10 id 5
                //4 id 6
                if (trim($data[X]) == "10") {
                    $curProduct->setTaxClass(5);
                } else if (trim($data[X]) == "4") {
                    $curProduct->setTaxClass(6);
                } else {
                    $curProduct->setTaxClass(2);
                }

                //name
                $nameENG = new DataExchange_Iris_Model_Data_Product_Attribute("name", "text", $data[X]);
                $curProduct->addAttribute($nameENG);

                //WEIGHT
                $weight = new DataExchange_Iris_Model_Data_Product_Attribute("weight", "text", $data[X]);
                $curProduct->addAttribute($weight);

                //PREZZO
                $price = new DataExchange_Iris_Model_Data_Product_Attribute("price", "price", $data[X]);
                $curProduct->addAttribute($price);


                //DESCRIZIONE
                $descrizione = new DataExchange_Iris_Model_Data_Product_Attribute("description", "text", $data[X]);
                $curProduct->addAttribute($descrizione);
                $descrizioneENG = new DataExchange_Iris_Model_Data_Product_Attribute("description", "textarea", $data[X]);
                $curProduct->addAttribute($descrizioneENG);




                $returnArray[] = $curProduct;
                $count++;
                if ($count == 5) {
                    return $returnArray;
                }
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
    
    private function isEmpty($field){
        if(empty($field)){
            return true;
        }else{
            return false;
        }
    }

    public function readDataVitamin($arrayProducts) {
        $returnArray = array();
        $count = 0;
        foreach ($arrayProducts as $prod) {

            //inizio il parsing
            $curProduct = new DataExchange_Iris_Model_Data_Product_Default();
            $curProduct->setSku($prod["sku"]);
            
            $curProduct->setSource("filepath");
            $curProduct->setProductType(Mage_Catalog_Model_Product_Type::TYPE_SIMPLE);

            $curProduct->setAttributeSetId(DataExchange_Iris_Model_Data_Product_Default::ATTRIBUTE_SET_ID_DEFAULT);
            $curProduct->setWebsiteIds("1,2");
            if(strtolower(trim($prod["sku"])) != strtolower(trim($prod["prodotto_configurabile"]))){
                $curProduct->setParentSku($prod["prodotto_configurabile"]);
            }
            $curProduct->setConfigurableAttributes($prod["attributo_configurabile"]);
            $curProduct->setProductStatus(DataExchange_Iris_Model_Data_Product_Default::STATUS_ENABLED);
            

            // visibility = 1 non visibile individualmente
            // visibility = 4 visibile catalogo e ricerca
            if ($prod["sku"] == $prod["prodotto_configurabile"]){
                //siamo nel prodotto semplice visibile
                $curProduct->setName($prod["name"]);
                $curProduct->setVisibility(4);
            }else{
                //siamo in un semplice che fa parte del configurabile
                $curProduct->setVisibility(1);
                if($prod["attributo_configurabile"] == "gusto"){
                    $curProduct->setName($prod["name"]."_gusto_".$prod["gusto"]);
                } else if($prod["attributo_configurabile"] == "taglia"){
                    $curProduct->setName($prod["name"]."_taglia_".$prod["taglia"]);
                } else if($prod["attributo_configurabile"] == "colore"){
                    $curProduct->setName($prod["name"]."_colore_".$prod["colore"]);
                } else if($prod["attributo_configurabile"] == "taglia,colore"){
                    $curProduct->setName($prod["name"]."_taglia_".$prod["taglia"]."_colore_".$prod["colore"]);
                } else{
                    $curProduct->setName($prod["name"]);
                }
            }

            //taxClass
            //21 id 2
            //10 id 5
            //4 id 6
            if ($prod["iva"] == "10") {
                $curProduct->setTaxClass(5);
            } else if ($prod["iva"] == "4") {
                $curProduct->setTaxClass(6);
            } else {
                $curProduct->setTaxClass(2);
            }
            
            //ecco le viste:
            //IT = 1
            //B2C IT = 2
            //EN = 3
            //B2C EN = 4

            //name
            if(!$this->isEmpty($prod["name_eng"])){
                $nameENG = new DataExchange_Iris_Model_Data_Product_Attribute("name", "text", $prod["name_eng"],3);
                $curProduct->addAttribute($nameENG);
                $nameENG = new DataExchange_Iris_Model_Data_Product_Attribute("name", "text", $prod["name_eng"],4);
                $curProduct->addAttribute($nameENG);
            }
            
            //WEIGHT
            $weight = new DataExchange_Iris_Model_Data_Product_Attribute("weight", "text", $prod["weight"]);
            $curProduct->addAttribute($weight);

            //PREZZO
            $price = new DataExchange_Iris_Model_Data_Product_Attribute("price", "price", $prod["price"]);
            $curProduct->addAttribute($price);
            
            //RATING
            if(!$this->isEmpty($prod["custom_rating"])){
                $rating = new DataExchange_Iris_Model_Data_Product_Attribute("custom_rating", "select", $prod["custom_rating"]);
                $curProduct->addAttribute($rating);            
            }

            //DESCRIZIONE_BREVE
            if(!$this->isEmpty($prod["short_description"])){
                $descrizione_breve = new DataExchange_Iris_Model_Data_Product_Attribute("short_description", "textarea", $prod["short_description"]);
                $curProduct->addAttribute($descrizione_breve);
            }
            
            if(!$this->isEmpty($prod["short_description_eng"])){
                $descrizione_breveENG = new DataExchange_Iris_Model_Data_Product_Attribute("short_description", "textarea", $prod["short_description_eng"],3);
                $curProduct->addAttribute($descrizione_breveENG);
                $descrizione_breveENG = new DataExchange_Iris_Model_Data_Product_Attribute("short_description", "textarea", $prod["short_description_eng"],4);
                $curProduct->addAttribute($descrizione_breveENG);            
            }
            
            //DESCRIZIONE
            if(!$this->isEmpty($prod["description"])){
                $descrizione = new DataExchange_Iris_Model_Data_Product_Attribute("description", "textarea", $prod["description"]);
                $curProduct->addAttribute($descrizione);
            }            
            
            if(!$this->isEmpty($prod["description_eng"])){            
                $descrizioneENG = new DataExchange_Iris_Model_Data_Product_Attribute("description", "textarea", $prod["description_eng"],3);
                $curProduct->addAttribute($descrizioneENG);
                $descrizioneENG = new DataExchange_Iris_Model_Data_Product_Attribute("description", "textarea", $prod["description_eng"],4);
                $curProduct->addAttribute($descrizioneENG);  
            }
            
            //INFORMAZIONI NUTRIZIONALI
            if(!$this->isEmpty($prod["informazioni_nutrizionali"])){
                $informazioni_nutrizionali = new DataExchange_Iris_Model_Data_Product_Attribute("informazioni_nutrizionali", "textarea", $prod["informazioni_nutrizionali"]);
                $curProduct->addAttribute($informazioni_nutrizionali);
            }
            
            if(!$this->isEmpty($prod["informazioni_nutrizionali_eng"])){            
                $informazioni_nutrizionaliENG = new DataExchange_Iris_Model_Data_Product_Attribute("informazioni_nutrizionali", "textarea", $prod["informazioni_nutrizionali_eng"],3);
                $curProduct->addAttribute($informazioni_nutrizionaliENG);
                $informazioni_nutrizionaliENG = new DataExchange_Iris_Model_Data_Product_Attribute("informazioni_nutrizionali", "textarea", $prod["informazioni_nutrizionali_eng"],4);
                $curProduct->addAttribute($informazioni_nutrizionaliENG);   
            }
            
            //CARATTERISTICHE
            if(!$this->isEmpty($prod["caratteristiche"])){
                $caratteristiche = new DataExchange_Iris_Model_Data_Product_Attribute("caratteristiche", "textarea", $prod["caratteristiche"]);
                $curProduct->addAttribute($caratteristiche);
            }
            
            if(!$this->isEmpty($prod["caratteristiche_eng"])){            
                $caratteristicheENG = new DataExchange_Iris_Model_Data_Product_Attribute("caratteristiche", "textarea", $prod["caratteristiche_eng"],3);
                $curProduct->addAttribute($caratteristicheENG);
                $caratteristicheENG = new DataExchange_Iris_Model_Data_Product_Attribute("caratteristiche", "textarea", $prod["caratteristiche_eng"],4);
                $curProduct->addAttribute($caratteristicheENG);   
            }            
            
            
            //COMPOSIZIONE
            if(!$this->isEmpty($prod["composizione"])){            
                $composizione = new DataExchange_Iris_Model_Data_Product_Attribute("composizione", "textarea", $prod["composizione"]);
                $curProduct->addAttribute($composizione);
            }
            
            if(!$this->isEmpty($prod["composizione_eng"])){            
                $composizioneENG = new DataExchange_Iris_Model_Data_Product_Attribute("composizione", "textarea", $prod["composizione_eng"],3);
                $curProduct->addAttribute($composizioneENG);
                $composizioneENG = new DataExchange_Iris_Model_Data_Product_Attribute("composizione", "textarea", $prod["composizione_eng"],4);
                $curProduct->addAttribute($composizioneENG);          
            }
            
            //MODO USO
            if(!$this->isEmpty($prod["modo_uso"])){            
                $modo_uso = new DataExchange_Iris_Model_Data_Product_Attribute("modo_uso", "textarea", $prod["modo_uso"]);
                $curProduct->addAttribute($modo_uso);
            }
            
            if(!$this->isEmpty($prod["modo_uso_eng"])){            
                $modo_usoENG = new DataExchange_Iris_Model_Data_Product_Attribute("modo_uso", "textarea", $prod["modo_uso_eng"],3);
                $curProduct->addAttribute($modo_usoENG);
                $modo_usoENG = new DataExchange_Iris_Model_Data_Product_Attribute("modo_uso", "textarea", $prod["modo_uso_eng"],4);
                $curProduct->addAttribute($modo_usoENG);            
            }
            
            
            //DOSAGGIO CONSIGLIATO
            if(!$this->isEmpty($prod["dosaggio_consigliato"])){            
                $dosaggio_consigliato = new DataExchange_Iris_Model_Data_Product_Attribute("dosaggio_consigliato", "textarea", $prod["dosaggio_consigliato"]);
                $curProduct->addAttribute($dosaggio_consigliato);
            }

            if(!$this->isEmpty($prod["dosaggio_consigliato_eng"])){            
                $dosaggio_consigliatoENG = new DataExchange_Iris_Model_Data_Product_Attribute("dosaggio_consigliato", "textarea", $prod["dosaggio_consigliato_eng"],3);
                $curProduct->addAttribute($dosaggio_consigliatoENG);
                $dosaggio_consigliatoENG = new DataExchange_Iris_Model_Data_Product_Attribute("dosaggio_consigliato", "textarea", $prod["dosaggio_consigliato_eng"],4);
                $curProduct->addAttribute($dosaggio_consigliatoENG);     
            }
            
            //AVVERTENZE
            if(!$this->isEmpty($prod["avvertenze"])){            
                $avvertenze = new DataExchange_Iris_Model_Data_Product_Attribute("avvertenze", "textarea", $prod["avvertenze"]);
                $curProduct->addAttribute($avvertenze);
            }
            
            if(!$this->isEmpty($prod["avvertenze_eng"])){            
                $avvertenzeENG = new DataExchange_Iris_Model_Data_Product_Attribute("avvertenze", "textarea", $prod["avvertenze_eng"],3);
                $curProduct->addAttribute($avvertenzeENG);
                $avvertenzeENG = new DataExchange_Iris_Model_Data_Product_Attribute("avvertenze", "textarea", $prod["avvertenze_eng"],4);
                $curProduct->addAttribute($avvertenzeENG);         
            }
            
            
            //META TITLE
            if(!$this->isEmpty($prod["meta_title"])){            
                $meta_title = new DataExchange_Iris_Model_Data_Product_Attribute("meta_title", "textarea", $prod["meta_title"]);
                $curProduct->addAttribute($meta_title);
            }

            if(!$this->isEmpty($prod["meta_title_eng"])){            
                $meta_titleENG = new DataExchange_Iris_Model_Data_Product_Attribute("meta_title", "textarea", $prod["meta_title_eng"],3);
                $curProduct->addAttribute($meta_titleENG);
                $meta_titleENG = new DataExchange_Iris_Model_Data_Product_Attribute("meta_title", "textarea", $prod["meta_title_eng"],4);
                $curProduct->addAttribute($meta_titleENG); 
            }
            
            //META DESCRIPTION
            if(!$this->isEmpty($prod["meta_description"])){            
            $meta_description = new DataExchange_Iris_Model_Data_Product_Attribute("meta_description", "textarea", $prod["meta_description"]);
            $curProduct->addAttribute($meta_description);
            }            
            
            if(!$this->isEmpty($prod["meta_description_eng"])){            
                $meta_descriptionENG = new DataExchange_Iris_Model_Data_Product_Attribute("meta_description", "textarea", $prod["meta_description_eng"],3);
                $curProduct->addAttribute($meta_descriptionENG);
                $meta_descriptionENG = new DataExchange_Iris_Model_Data_Product_Attribute("meta_description", "textarea", $prod["meta_description_eng"],4);
                $curProduct->addAttribute($meta_descriptionENG);     
            }
            
            //GUSTO
            if(!$this->isEmpty($prod["gusto"])){
                $gusto = new DataExchange_Iris_Model_Data_Product_Attribute("gusto", "select", $prod["gusto"]);
                $curProduct->addAttribute($gusto);
            }
            
            //COLORE
            if(!$this->isEmpty($prod["colore"])){
                $colore = new DataExchange_Iris_Model_Data_Product_Attribute("colore", "select", $prod["colore"]);
                $curProduct->addAttribute($colore);
            }            
            
            //TAGLIA
            if(!$this->isEmpty($prod["taglia"])){
                $taglia = new DataExchange_Iris_Model_Data_Product_Attribute("taglia", "select", $prod["taglia"]);
                $curProduct->addAttribute($taglia);
            }                        
            
            //VISIBILE ANONIMO
            // prodotto_nascosto yes|1 OPPURE no|0
            if(trim($prod["visibile_anonimo"]) == "SI"){
                $prodotto_nascosto = new DataExchange_Iris_Model_Data_Product_Attribute("prodotto_nascosto", "text", "0");
                $curProduct->addAttribute($prodotto_nascosto);
            }else{
                $prodotto_nascosto = new DataExchange_Iris_Model_Data_Product_Attribute("prodotto_nascosto", "text", "1");
                $curProduct->addAttribute($prodotto_nascosto);
            }
            
            //BRAND
            if($prod["brand"]){
                $collection = Mage::getModel("awshopbybrand/brand")->getCollection()->addFieldToFilter('code', $prod["brand"])->setPageSize(1);
                $brand = $collection->getFirstItem();
                $curBrand = new DataExchange_Iris_Model_Data_Product_Attribute("aw_shopbybrand_brand", "text", $brand->getId());
                $curProduct->addAttribute($curBrand);                                
            }
            
            //URL_KEY
            if($prod["name_eng"] && $prod["sku"] == $prod["prodotto_configurabile"]){                
                $urlENG = new DataExchange_Iris_Model_Data_Product_Attribute("url_key", "text", Mage::getModel('catalog/product_url')->formatUrlKey($prod["name_eng"]), 3);
                $curProduct->addAttribute($urlENG);
                
                $urlENG = new DataExchange_Iris_Model_Data_Product_Attribute("url_key", "text", Mage::getModel('catalog/product_url')->formatUrlKey($prod["name_eng"]), 4);
                $curProduct->addAttribute($urlENG);                
            }            

                                    

            $returnArray[] = $curProduct;
            $count++;
//            if ($count == 5) {
//                return $returnArray;
//            }            
        }
        return $returnArray;
    }

}

?>
