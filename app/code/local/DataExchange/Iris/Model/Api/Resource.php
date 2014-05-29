<?php

class ReturnObject {

    /** @var String  */
    public $result_code;

    /** @var String */
    public $result_data;

}

class SimpleProduct {

    /** @var String  */
    public $sku;

    /** @var String  */
    public $name;

    /** @var String  */
    public $price;

    //nuovi attributi

    /** @var String  */
    public $name_eng;

    /** @var String  */
    public $custom_rating;

    /** @var String  */
    public $short_description;

    /** @var String  */
    public $short_description_eng;

    /** @var String  */
    public $description;

    /** @var String  */
    public $description_eng;

    /** @var String  */
    public $informazioni_nutrizionali;

    /** @var String  */
    public $informazioni_nutrizionali_eng;

    /** @var String  */
    public $caratteristiche;

    /** @var String  */
    public $caratteristiche_eng;

    /** @var String  */
    public $composizione;

    /** @var String  */
    public $composizione_eng;

    /** @var String  */
    public $modo_uso;

    /** @var String  */
    public $modo_uso_eng;

    /** @var String  */
    public $dosaggio_consigliato;

    /** @var String  */
    public $dosaggio_consigliato_eng;

    /** @var String  */
    public $avvertenze;

    /** @var String  */
    public $avvertenze_eng;

    /** @var String  */
    public $meta_title;

    /** @var String  */
    public $meta_title_eng;

    /** @var String  */
    public $meta_keywords;

    /** @var String  */
    public $meta_keywords_eng;

    /** @var String  */
    public $meta_description;

    /** @var String  */
    public $meta_description_eng;

    /** @var String  */
    public $weight;

    /** @var String  */
    public $visibile_anonimo;

    /** @var String  */
    public $brand;

    /** @var String  */
    public $ingredienti;

    /** @var String  */
    public $iva;

    /** @var String  */
    public $category_ids;

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
    public $name_eng;

    /** @var String  */
    public $custom_rating;

    /** @var String  */
    public $short_description;

    /** @var String  */
    public $short_description_eng;

    /** @var String  */
    public $description;

    /** @var String  */
    public $description_eng;

    /** @var String  */
    public $informazioni_nutrizionali;

    /** @var String  */
    public $informazioni_nutrizionali_eng;

    /** @var String  */
    public $caratteristiche;

    /** @var String  */
    public $caratteristiche_eng;

    /** @var String  */
    public $composizione;

    /** @var String  */
    public $composizione_eng;

    /** @var String  */
    public $modo_uso;

    /** @var String  */
    public $modo_uso_eng;

    /** @var String  */
    public $dosaggio_consigliato;

    /** @var String  */
    public $dosaggio_consigliato_eng;

    /** @var String  */
    public $avvertenze;

    /** @var String  */
    public $avvertenze_eng;

    /** @var String  */
    public $meta_title;

    /** @var String  */
    public $meta_title_eng;

    /** @var String  */
    public $meta_keywords;

    /** @var String  */
    public $meta_keywords_eng;

    /** @var String  */
    public $meta_description;

    /** @var String  */
    public $meta_description_eng;

    /** @var String  */
    public $weight;

    /** @var String  */
    public $visibile_anonimo;

    /** @var String  */
    public $brand;

    /** @var String  */
    public $ingredienti;

    /** @var String  */
    public $iva;

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

class ExportPrice {

    /** @var String  */
    public $sku;

    /** @var String  */
    public $price;

}

class ExportPrices {

    /** @var String  */
    public $result_code;

    /** @var ExportPrice[]  */
    public $exportPricesArray = array();

}

class ExportStock {

    /** @var String  */
    public $expiry;

    /** @var String  */
    public $qty;

}

class ExportStocks {

    /** @var String  */
    public $result_code;

    /** @var ExportStock[]  */
    public $exportStocksArray = array();

}

class BrandObject {

    /** @var String  */
    public $code;

    /** @var String  */
    public $title;

    /** @var String  */
    public $title_eng;

    /** @var String  */
    public $description;

    /** @var String  */
    public $description_eng;

    /** @var String  */
    public $meta_description;

    /** @var String  */
    public $meta_description_eng;

    /** @var String  */
    public $name;

    /** @var String  */
    public $fascia_sconto;

    /** @var String  */
    public $immagine;

}

class Label {

    /** @var String  */
    public $sku;

    /** @var String  */
    public $label;

}

class LabelsUpdate {

    /** @var Label[]  */
    public $labels = array();

}

class SkuExist {

    /** @var String  */
    public $sku;

    /** @var String  */
    public $exist;

}

class SkuExistResult {

    /** @var SkuExist[]  */
    public $skus = array();

}

class DataExchange_Iris_Model_Api_Resource extends Mage_Api_Model_Resource_Abstract {

    const WS_VALIDATION_ERROR_DATE = 'errore in validazione input data';
    const WS_RESULT_NOT_FOUND = "Result not found";
    const WS_GENERIC_ERROR = "error";
    const SUFFIX_DUPLICATED_PRODUCT = "_sc";
    const BRAND_ALREADY_EXISTS = "brand already exist";
    const EXPIRY_ATTRIBUTE = "scadenza";

    /**
     * questa funzione riscrive gli error/exception handler in modo che possano essere intercettati e passati alla funzione di log; 
     * così che tutti i log si success e errore facciano parte del file log dei webservices
     */
    private function __setErrorHandlers() {
        set_error_handler(array($this, 'wsErrorHandler'), E_ALL);
        register_shutdown_function(array($this, 'fatalErrorShutdownHandler'));
        //set_exception_handler(array($this, "wsExceptionHandler"));   //non funziona!
    }

    public function wsErrorHandler($errno, $errstr, $errfile = null, $errline = null, array $errcontext = null) {
        $errorMessage = ": {$errstr}  in {$errfile} on line {$errline}";
        $this->__logCall(__METHOD__, $errorMessage, Zend_Log::ERR);
        return true;
    }

    public function wsExceptionHandler($exception) {
        $this->__logCall(__METHOD__, $exception, Zend_Log::ERR);
    }

    public function fatalErrorShutdownHandler() {
        $last_error = error_get_last();
        if ($last_error['type'] === E_ERROR) {
            // fatal error
            $this->wsErrorHandler(E_ERROR, $last_error['message'], $last_error['file'], $last_error['line']);
        }
    }

    /**
     * create a log for the call
     */
    private function __logCall($functionName, $message, $level = null) {
        Mage::log($_SERVER);
        $logMessage = "Call " . $functionName . " - " . $message;
        Mage::helper("iris/log")->log($logMessage, $level);
    }

    public function hello($data) {
        try {
            $this->__setErrorHandlers();
            $this->__logCall(__METHOD__, "started");


            $this->__logCall(__METHOD__, "ended");
            return "hello, il primo webservice!";
        } catch (Exception $e) {
            $this->__logCall(__METHOD__, "Exception: " . $e->getMessage(), Zend_Log::ERR);
        }
    }

    public function exportTest($orderId, $dateFrom, $dateTo, $status) {
        try {
            $this->__setErrorHandlers();
            $this->__logCall(__METHOD__, "started");

            if (!Mage::helper("iris/validation")->validateInput($dateFrom, "date")) {
                
            }

            if (!Mage::helper("iris/validation")->validateInput($dateFrom, "date")) {
                
            }




            $returnArray = array();
            $returnArray[] = array("1" => "1", "2" => "2");

            $return = new ReturnObject();
            $return->result_code = "SUCCESS";
            $return->result_data = $returnArray;



            $this->__logCall(__METHOD__, "ended");
            return $return;
        } catch (Exception $e) {
            $this->__logCall(__METHOD__, "Exception: " . $e->getMessage(), Zend_Log::ERR);
        }
    }

    /**
     * 
     * @param type $orderId
     * @param type $dateFrom stringa nel formato 'yyyy-MM-dd H:i:s'
     * @param type $dateTo string nel formato 'yyyy-MM-dd H:i:s'
     * @param type $status
     * @return \ReturnObject Ritorna orderId se orderId esiste. Altrimenti ritorna gli ordini nello stato indicato, >= dateFrom e <= dateTo
     */
    public function exportOrders($orderId, $dateFrom, $dateTo, $status) {
        try {
            $this->__setErrorHandlers();
            $this->__logCall(__METHOD__, "started");
            $return = Mage::helper("iris/order")->getOrderExportObject();
            $return->result_code = "SUCCESS";


            //se orderId
            if ($orderId != "" && $orderId != null) {
                $orders_collection = Mage::getModel('sales/order')
                        ->getCollection()
                        ->addAttributeToSelect('*')
                        ->addAttributeToFilter('increment_id', array("eq" => $orderId));

                if ($orders_collection->count() != 1) {
                    $return->result_code = DataExchange_Iris_Model_Api_Resource::WS_RESULT_NOT_FOUND;
                    return $return;
                }
                $orderToReturn = $orders_collection->getFirstItem();
                $return->orders[] = Mage::helper("iris/order")->exportSingleOrderDataObject($orderToReturn->getId());
            } else {
                if (!Mage::helper("iris/validation")->validateInput($dateFrom, "date")) {
                    $return->result_code = DataExchange_Iris_Model_Api_Resource::WS_VALIDATION_ERROR_DATE;
                    return $return;
                }

                if (!Mage::helper("iris/validation")->validateInput($dateTo, "date")) {
                    $return->result_code = DataExchange_Iris_Model_Api_Resource::WS_VALIDATION_ERROR_DATE;
                    return $return;
                }
                
                $dateFrom = Mage::getSingleton('core/date')->gmtDate(null,$dateFrom);
                $dateTo = Mage::getSingleton('core/date')->gmtDate(null,$dateTo);
                        
                
                $orders_collection = Mage::getModel('sales/order')->getCollection();
                $orders_collection->addAttributeToSelect('*');
                $orders_collection->addAttributeToFilter('created_at', array(
                    'from' => $dateFrom,
                    'to' => $dateTo,
                ));
                if ($status != null && $status != "") {
                    $orders_collection->addAttributeToFilter('status', array('eq' => $status));
                }

                foreach ($orders_collection as $order) {
                    $return->orders[] = Mage::helper("iris/order")->exportSingleOrderDataObject($order->getId());
                }
            }

            $this->__logCall(__METHOD__, "ended");
            $return->result_code = "SUCCESS";
            return $return;
        } catch (Exception $e) {
            $this->__logCall(__METHOD__, "Exception: " . $e->getMessage(), Zend_Log::ERR);
        }
    }

    public function exportPrices($dateFrom, $dateTo) {
        try {
            $this->__setErrorHandlers();
            $this->__logCall(__METHOD__, "started");
            $return = new ExportPrices();
            $return->result_code = "SUCCESS";


            if (!Mage::helper("iris/validation")->validateInput($dateFrom, "date")) {
                $return->result_code = DataExchange_Iris_Model_Api_Resource::WS_VALIDATION_ERROR_DATE;
                return $return;
            }

            if (!Mage::helper("iris/validation")->validateInput($dateTo, "date")) {
                $return->result_code = DataExchange_Iris_Model_Api_Resource::WS_VALIDATION_ERROR_DATE;
                return $return;
            }

            $product_collection = Mage::getModel('catalog/product')->getCollection();
            $product_collection->addAttributeToSelect('price');
            $product_collection->addAttributeToFilter('updated_at', array(
                'from' => $dateFrom,
                'to' => $dateTo,
            ));


            foreach ($product_collection as $product) {
                if ($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_SIMPLE) {
                    //$currentExportArray = array("sku" => $product->getSku(), "price" => $product->getFinalPrice());
                    $currentExportArray = new ExportPrice();
                    $currentExportArray->sku = $product->getSku();
                    $currentExportArray->price = $product->getPrice();
                    $return->exportPricesArray[] = $currentExportArray;
                }
            }

            $this->__logCall(__METHOD__, "ended");
            return $return;
        } catch (Exception $e) {
            $this->__logCall(__METHOD__, "Exception: " . $e->getMessage(), Zend_Log::ERR);
            $return->result_code = "Exception: " . $e->getMessage();
            return $return;
        }
    }

    public function importSimpleProduct($simple) {
        try {
            $this->__setErrorHandlers();
            $this->__logCall(__METHOD__, "started");
            $return = new ReturnObject();
            $return->result_code = "SUCCESS";

            Mage::helper("iris/log")->log($simple);

            $curProduct = new DataExchange_Iris_Model_Data_Product_Default();
            $curProduct->setSku($simple->sku);
            $curProduct->setSource("webservice");
            $curProduct->setProductType(Mage_Catalog_Model_Product_Type::TYPE_SIMPLE);

            $curProduct->setAttributeSetId(DataExchange_Iris_Model_Data_Product_Default::ATTRIBUTE_SET_ID_DEFAULT);
            //$curProduct->setWebsiteIds(DataExchange_Iris_Model_Data_Product_Default::WEBSITE_IDS_DEFAULT);
            $curProduct->setWebsiteIds("1,2");

            //taxClass
            //21 id 2
            //10 id 5
            //4 id 6
            if ($simple->iva == "10") {
                $curProduct->setTaxClass(5);
            } else if ($simple->iva == "04") {
                $curProduct->setTaxClass(6);
            } else {
                $curProduct->setTaxClass(2);
            }
            //$curProduct->setTaxClass(DataExchange_Iris_Model_Data_Product_Default::TAX_CLASS_DEFAULT);
            $curProduct->setVisibility(DataExchange_Iris_Model_Data_Product_Default::VISIBILITY_ALL);
            $curProduct->setProductStatus(DataExchange_Iris_Model_Data_Product_Default::STATUS_DISABLED);




            $curProduct->setName($simple->name);

            $price = new DataExchange_Iris_Model_Data_Product_Attribute("price", "text", $simple->price);
            $curProduct->addAttribute($price);

            //aggiunta nuovi attributi
            //
            //vetrine inglesi id: 3,4
            //WEIGHT
            $weight = new DataExchange_Iris_Model_Data_Product_Attribute("weight", "text", $simple->weight);
            $curProduct->addAttribute($weight);

            //RATING
            if (!$this->isEmpty($simple->custom_rating)) {
                $rating = new DataExchange_Iris_Model_Data_Product_Attribute("custom_rating", "select", $simple->custom_rating);
                $curProduct->addAttribute($rating);
            }

            //DESCRIZIONE_BREVE
            if (!$this->isEmpty($simple->short_description)) {
                $descrizione_breve = new DataExchange_Iris_Model_Data_Product_Attribute("short_description", "textarea", $simple->short_description);
                $curProduct->addAttribute($descrizione_breve);
            }

            if (!$this->isEmpty($simple->short_description_eng)) {
                $descrizione_breveENG = new DataExchange_Iris_Model_Data_Product_Attribute("short_description", "textarea", $simple->short_description_eng, 3);
                $curProduct->addAttribute($descrizione_breveENG);
                $descrizione_breveENG = new DataExchange_Iris_Model_Data_Product_Attribute("short_description", "textarea", $simple->short_description_eng, 4);
                $curProduct->addAttribute($descrizione_breveENG);
            }

            //DESCRIZIONE
            if (!$this->isEmpty($simple->description)) {
                $descrizione = new DataExchange_Iris_Model_Data_Product_Attribute("description", "textarea", $simple->description);
                $curProduct->addAttribute($descrizione);
            }

            if (!$this->isEmpty($simple->description_eng)) {
                $descrizioneENG = new DataExchange_Iris_Model_Data_Product_Attribute("description", "textarea", $simple->description_eng, 3);
                $curProduct->addAttribute($descrizioneENG);
                $descrizioneENG = new DataExchange_Iris_Model_Data_Product_Attribute("description", "textarea", $simple->description_eng, 4);
                $curProduct->addAttribute($descrizioneENG);
            }

            //INFORMAZIONI NUTRIZIONALI
            if (!$this->isEmpty($simple->informazioni_nutrizionali)) {
                $informazioni_nutrizionali = new DataExchange_Iris_Model_Data_Product_Attribute("informazioni_nutrizionali", "textarea", $simple->informazioni_nutrizionali);
                $curProduct->addAttribute($informazioni_nutrizionali);
            }

            if (!$this->isEmpty($simple->informazioni_nutrizionali_eng)) {
                $informazioni_nutrizionaliENG = new DataExchange_Iris_Model_Data_Product_Attribute("informazioni_nutrizionali", "textarea", $simple->informazioni_nutrizionali_eng, 3);
                $curProduct->addAttribute($informazioni_nutrizionaliENG);
                $informazioni_nutrizionaliENG = new DataExchange_Iris_Model_Data_Product_Attribute("informazioni_nutrizionali", "textarea", $simple->informazioni_nutrizionali_eng, 4);
                $curProduct->addAttribute($informazioni_nutrizionaliENG);
            }

            //CARATTERISTICHE
            if (!$this->isEmpty($simple->caratteristiche)) {
                $caratteristiche = new DataExchange_Iris_Model_Data_Product_Attribute("caratteristiche", "textarea", $simple->caratteristiche);
                $curProduct->addAttribute($caratteristiche);
            }

            if (!$this->isEmpty($simple->caratteristiche_eng)) {
                $caratteristicheENG = new DataExchange_Iris_Model_Data_Product_Attribute("caratteristiche", "textarea", $simple->caratteristiche_eng, 3);
                $curProduct->addAttribute($caratteristicheENG);
                $caratteristicheENG = new DataExchange_Iris_Model_Data_Product_Attribute("caratteristiche", "textarea", $simple->caratteristiche_eng, 4);
                $curProduct->addAttribute($caratteristicheENG);
            }


            //COMPOSIZIONE
            if (!$this->isEmpty($simple->composizione)) {
                $composizione = new DataExchange_Iris_Model_Data_Product_Attribute("composizione", "textarea", $simple->composizione);
                $curProduct->addAttribute($composizione);
            }

            if (!$this->isEmpty($simple->composizione_eng)) {
                $composizioneENG = new DataExchange_Iris_Model_Data_Product_Attribute("composizione", "textarea", $simple->composizione_eng, 3);
                $curProduct->addAttribute($composizioneENG);
                $composizioneENG = new DataExchange_Iris_Model_Data_Product_Attribute("composizione", "textarea", $simple->composizione_eng, 4);
                $curProduct->addAttribute($composizioneENG);
            }

            //MODO USO
            if (!$this->isEmpty($simple->modo_uso)) {
                $modo_uso = new DataExchange_Iris_Model_Data_Product_Attribute("modo_uso", "textarea", $simple->modo_uso);
                $curProduct->addAttribute($modo_uso);
            }

            if (!$this->isEmpty($simple->modo_uso_eng)) {
                $modo_usoENG = new DataExchange_Iris_Model_Data_Product_Attribute("modo_uso", "textarea", $simple->modo_uso_eng, 3);
                $curProduct->addAttribute($modo_usoENG);
                $modo_usoENG = new DataExchange_Iris_Model_Data_Product_Attribute("modo_uso", "textarea", $simple->modo_uso_eng, 4);
                $curProduct->addAttribute($modo_usoENG);
            }


            //DOSAGGIO CONSIGLIATO
            if (!$this->isEmpty($simple->dosaggio_consigliato)) {
                $dosaggio_consigliato = new DataExchange_Iris_Model_Data_Product_Attribute("dosaggio_consigliato", "textarea", $simple->dosaggio_consigliato);
                $curProduct->addAttribute($dosaggio_consigliato);
            }

            if (!$this->isEmpty($simple->dosaggio_consigliato_eng)) {
                $dosaggio_consigliatoENG = new DataExchange_Iris_Model_Data_Product_Attribute("dosaggio_consigliato", "textarea", $simple->dosaggio_consigliato_eng, 3);
                $curProduct->addAttribute($dosaggio_consigliatoENG);
                $dosaggio_consigliatoENG = new DataExchange_Iris_Model_Data_Product_Attribute("dosaggio_consigliato", "textarea", $simple->dosaggio_consigliato_eng, 4);
                $curProduct->addAttribute($dosaggio_consigliatoENG);
            }

            //AVVERTENZE
            if (!$this->isEmpty($simple->avvertenze)) {
                $avvertenze = new DataExchange_Iris_Model_Data_Product_Attribute("avvertenze", "textarea", $simple->avvertenze);
                $curProduct->addAttribute($avvertenze);
            }

            if (!$this->isEmpty($simple->avvertenze_eng)) {
                $avvertenzeENG = new DataExchange_Iris_Model_Data_Product_Attribute("avvertenze", "textarea", $simple->avvertenze_eng, 3);
                $curProduct->addAttribute($avvertenzeENG);
                $avvertenzeENG = new DataExchange_Iris_Model_Data_Product_Attribute("avvertenze", "textarea", $simple->avvertenze_eng, 4);
                $curProduct->addAttribute($avvertenzeENG);
            }


            //META TITLE
            if (!$this->isEmpty($simple->meta_title)) {
                $meta_title = new DataExchange_Iris_Model_Data_Product_Attribute("meta_title", "textarea", $simple->meta_title);
                $curProduct->addAttribute($meta_title);
            }

            if (!$this->isEmpty($simple->meta_title_eng)) {
                $meta_titleENG = new DataExchange_Iris_Model_Data_Product_Attribute("meta_title", "textarea", $simple->meta_title_eng, 3);
                $curProduct->addAttribute($meta_titleENG);
                $meta_titleENG = new DataExchange_Iris_Model_Data_Product_Attribute("meta_title", "textarea", $simple->meta_title_eng, 4);
                $curProduct->addAttribute($meta_titleENG);
            }

            //META KEYWORD
            if (!$this->isEmpty($simple->meta_keyword)) {
                $meta_keyword = new DataExchange_Iris_Model_Data_Product_Attribute("meta_keyword", "text", $simple->meta_keyword);
                $curProduct->addAttribute($meta_keyword);
            }

            if (!$this->isEmpty($simple->meta_keyword_eng)) {
                $meta_keywordENG = new DataExchange_Iris_Model_Data_Product_Attribute("meta_keyword", "text", $simple->meta_keyword_eng, 3);
                $curProduct->addAttribute($meta_keywordENG);
                $meta_keywordENG = new DataExchange_Iris_Model_Data_Product_Attribute("meta_keyword", "text", $simple->meta_keyword_eng, 4);
                $curProduct->addAttribute($meta_keywordENG);
            }

            //META DESCRIPTION
            if (!$this->isEmpty($simple->meta_description)) {
                $meta_description = new DataExchange_Iris_Model_Data_Product_Attribute("meta_description", "textarea", $simple->meta_description);
                $curProduct->addAttribute($meta_description);
            }

            if (!$this->isEmpty($simple->meta_description_eng)) {
                $meta_descriptionENG = new DataExchange_Iris_Model_Data_Product_Attribute("meta_description", "textarea", $simple->meta_description_eng, 3);
                $curProduct->addAttribute($meta_descriptionENG);
                $meta_descriptionENG = new DataExchange_Iris_Model_Data_Product_Attribute("meta_description", "textarea", $simple->meta_description_eng, 4);
                $curProduct->addAttribute($meta_descriptionENG);
            }


            //VISIBILE ANONIMO
            // prodotto_nascosto yes|1 OPPURE no|0
            if (trim($simple->visibile_anonimo) == "SI") {
                $prodotto_nascosto = new DataExchange_Iris_Model_Data_Product_Attribute("prodotto_nascosto", "text", "0");
                $curProduct->addAttribute($prodotto_nascosto);
            } else {
                $prodotto_nascosto = new DataExchange_Iris_Model_Data_Product_Attribute("prodotto_nascosto", "text", "1");
                $curProduct->addAttribute($prodotto_nascosto);
            }

            //BRAND
            if ($simple->brand) {
                $collection = Mage::getModel("awshopbybrand/brand")->getCollection()->addFieldToFilter('code', $simple->brand)->setPageSize(1);
                $brand = $collection->getFirstItem();
                $curBrand = new DataExchange_Iris_Model_Data_Product_Attribute("aw_shopbybrand_brand", "text", $brand->getId());
                $curProduct->addAttribute($curBrand);
            }

            //URL_KEY
            $url = new DataExchange_Iris_Model_Data_Product_Attribute("url_key", "text", Mage::getModel('catalog/product_url')->formatUrlKey($simple->name));
            $curProduct->addAttribute($url);

            if ($simple->name_eng) {
                $urlENG = new DataExchange_Iris_Model_Data_Product_Attribute("url_key", "text", Mage::getModel('catalog/product_url')->formatUrlKey($simple->name_eng), 3);
                $curProduct->addAttribute($urlENG);
                $urlENG = new DataExchange_Iris_Model_Data_Product_Attribute("url_key", "text", Mage::getModel('catalog/product_url')->formatUrlKey($simple->name_eng), 4);
                $curProduct->addAttribute($urlENG);
            }

            if ($simple->category_ids) {
                $curProduct->setCategoryIds($simple->category_ids);
            }

            $dal = new DataExchange_Iris_Model_Dal_Product_Default();
            $actionId = $dal->insertData($curProduct);

            $consumer = new DataExchange_Iris_Model_Consumer_Default();
            $consumer->consumeSimpleProductRow($actionId);

            $this->__logCall(__METHOD__, "ended");
            return $return;
        } catch (Exception $e) {
            $this->__logCall(__METHOD__, "Exception: " . $e->getMessage(), Zend_Log::ERR);
            $return = new ReturnObject();
            $return->result_code = "Exception: " . $e->getMessage();
            return $return;
        }
    }

    public function importConfigurableProduct($configurable) {
        try {
            $this->__setErrorHandlers();
            $this->__logCall(__METHOD__, "started");
            $return = new ReturnObject();
            $return->result_code = "SUCCESS";

            Mage::helper("iris/log")->log($configurable);
            if (Mage::getModel("catalog/product")->getIdBySku($configurable->sku)) {
                $return->result_code = "ERROR: sku already exists";
                return $return;
            }
            //inserisco le azioni dei semplici
            foreach ($configurable->simpleProductArray as $simple) {
                Mage::helper("iris/log")->log($simple);

                $simpleProduct = new DataExchange_Iris_Model_Data_Product_Default();
                $simpleProduct->setSku($simple->sku);
                $simpleProduct->setSource("webservice");
                $simpleProduct->setProductType(Mage_Catalog_Model_Product_Type::TYPE_SIMPLE);

                $simpleProduct->setAttributeSetId(DataExchange_Iris_Model_Data_Product_Default::ATTRIBUTE_SET_ID_DEFAULT);
                //$curProduct->setWebsiteIds(DataExchange_Iris_Model_Data_Product_Default::WEBSITE_IDS_DEFAULT);
                $simpleProduct->setWebsiteIds("1,2");
                //$simpleProduct->setTaxClass(DataExchange_Iris_Model_Data_Product_Default::TAX_CLASS_DEFAULT);
                if ($simple->iva == "10") {
                    $simpleProduct->setTaxClass(5);
                } else if ($simple->iva == "04") {
                    $simpleProduct->setTaxClass(6);
                } else {
                    $simpleProduct->setTaxClass(2);
                }

                $simpleProduct->setVisibility(DataExchange_Iris_Model_Data_Product_Default::VISIBILITY_DEFAULT);
                $simpleProduct->setProductStatus(DataExchange_Iris_Model_Data_Product_Default::STATUS_ENABLED);
                $simpleProduct->setParentSku($configurable->sku);
                $simpleProduct->setName($simple->name);

                //WEIGHT
                $weight = new DataExchange_Iris_Model_Data_Product_Attribute("weight", "text", $simple->weight);
                $simpleProduct->addAttribute($weight);

                //BRAND
                if ($simple->brand) {
                    $collection = Mage::getModel("awshopbybrand/brand")->getCollection()->addFieldToFilter('code', $simple->brand)->setPageSize(1);
                    $brand = $collection->getFirstItem();
                    $curBrand = new DataExchange_Iris_Model_Data_Product_Attribute("aw_shopbybrand_brand", "text", $brand->getId());
                    $simpleProduct->addAttribute($curBrand);
                }


                //$name = new DataExchange_Iris_Model_Data_Product_Attribute("name", "text", $simple->name);
                //$simpleProduct->addAttribute($name);            

                $price = new DataExchange_Iris_Model_Data_Product_Attribute("price", "text", $simple->price);
                $simpleProduct->addAttribute($price);


                //attributi aggiuntivi
                //per ogni attributo configurabile inserito l'azione_attributo
                $attritutesToUseForCreateConf = explode(",", trim($configurable->configurableAttributes));
                foreach ($attritutesToUseForCreateConf as $attributeCode) {
                    $attributeValue = "";
                    foreach ($simple->attributeArray as $simpleAttr) {
                        if ($simpleAttr->attributeCode == $attributeCode) {
                            $attributeValue = $simpleAttr->attributeValue;
                        }
                    }
                    $attr = new DataExchange_Iris_Model_Data_Product_Attribute($attributeCode, "select", $attributeValue);
                    $simpleProduct->addAttribute($attr);
                }

                $dal = new DataExchange_Iris_Model_Dal_Product_Default();
                $actionId = $dal->insertData($simpleProduct);

                $consumer = new DataExchange_Iris_Model_Consumer_Default();
                $consumer->consumeSimpleProductRow($actionId);
            }


            //inserisco l'azione del configurabile
            $curProduct = new DataExchange_Iris_Model_Data_Product_Default();
            $curProduct->setSku($configurable->sku);
            $curProduct->setSource("webservice");
            $curProduct->setProductType(Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE);

            $curProduct->setAttributeSetId(DataExchange_Iris_Model_Data_Product_Default::ATTRIBUTE_SET_ID_DEFAULT);
            $curProduct->setWebsiteIds("1,2");
            if ($configurable->iva == "10") {
                $curProduct->setTaxClass(5);
            } else if ($configurable->iva == "04") {
                $curProduct->setTaxClass(6);
            } else {
                $curProduct->setTaxClass(2);
            }

            $curProduct->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH);
            $curProduct->setProductStatus(DataExchange_Iris_Model_Data_Product_Default::STATUS_DISABLED);
            $curProduct->setConfigurableAttributes($configurable->configurableAttributes);
            $curProduct->setName($configurable->name);

            //attributi aggiuntivi
            //RATING
            if (!$this->isEmpty($configurable->custom_rating)) {
                $rating = new DataExchange_Iris_Model_Data_Product_Attribute("custom_rating", "select", $configurable->custom_rating);
                $curProduct->addAttribute($rating);
            }

            //DESCRIZIONE_BREVE
            if (!$this->isEmpty($configurable->short_description)) {
                $descrizione_breve = new DataExchange_Iris_Model_Data_Product_Attribute("short_description", "textarea", $configurable->short_description);
                $curProduct->addAttribute($descrizione_breve);
            }

            if (!$this->isEmpty($configurable->short_description_eng)) {
                $descrizione_breveENG = new DataExchange_Iris_Model_Data_Product_Attribute("short_description", "textarea", $configurable->short_description_eng, 3);
                $curProduct->addAttribute($descrizione_breveENG);
                $descrizione_breveENG = new DataExchange_Iris_Model_Data_Product_Attribute("short_description", "textarea", $configurable->short_description_eng, 4);
                $curProduct->addAttribute($descrizione_breveENG);
            }

            //DESCRIZIONE
            if (!$this->isEmpty($configurable->description)) {
                $descrizione = new DataExchange_Iris_Model_Data_Product_Attribute("description", "textarea", $configurable->description);
                $curProduct->addAttribute($descrizione);
            }

            if (!$this->isEmpty($configurable->description_eng)) {
                $descrizioneENG = new DataExchange_Iris_Model_Data_Product_Attribute("description", "textarea", $configurable->description_eng, 3);
                $curProduct->addAttribute($descrizioneENG);
                $descrizioneENG = new DataExchange_Iris_Model_Data_Product_Attribute("description", "textarea", $configurable->description_eng, 4);
                $curProduct->addAttribute($descrizioneENG);
            }

            //INFORMAZIONI NUTRIZIONALI
            if (!$this->isEmpty($configurable->informazioni_nutrizionali)) {
                $informazioni_nutrizionali = new DataExchange_Iris_Model_Data_Product_Attribute("informazioni_nutrizionali", "textarea", $configurable->informazioni_nutrizionali);
                $curProduct->addAttribute($informazioni_nutrizionali);
            }

            if (!$this->isEmpty($configurable->informazioni_nutrizionali_eng)) {
                $informazioni_nutrizionaliENG = new DataExchange_Iris_Model_Data_Product_Attribute("informazioni_nutrizionali", "textarea", $configurable->informazioni_nutrizionali_eng, 3);
                $curProduct->addAttribute($informazioni_nutrizionaliENG);
                $informazioni_nutrizionaliENG = new DataExchange_Iris_Model_Data_Product_Attribute("informazioni_nutrizionali", "textarea", $configurable->informazioni_nutrizionali_eng, 4);
                $curProduct->addAttribute($informazioni_nutrizionaliENG);
            }

            //CARATTERISTICHE
            if (!$this->isEmpty($configurable->caratteristiche)) {
                $caratteristiche = new DataExchange_Iris_Model_Data_Product_Attribute("caratteristiche", "textarea", $configurable->caratteristiche);
                $curProduct->addAttribute($caratteristiche);
            }

            if (!$this->isEmpty($configurable->caratteristiche_eng)) {
                $caratteristicheENG = new DataExchange_Iris_Model_Data_Product_Attribute("caratteristiche", "textarea", $configurable->caratteristiche_eng, 3);
                $curProduct->addAttribute($caratteristicheENG);
                $caratteristicheENG = new DataExchange_Iris_Model_Data_Product_Attribute("caratteristiche", "textarea", $configurable->caratteristiche_eng, 4);
                $curProduct->addAttribute($caratteristicheENG);
            }


            //COMPOSIZIONE
            if (!$this->isEmpty($configurable->composizione)) {
                $composizione = new DataExchange_Iris_Model_Data_Product_Attribute("composizione", "textarea", $configurable->composizione);
                $curProduct->addAttribute($composizione);
            }

            if (!$this->isEmpty($configurable->composizione_eng)) {
                $composizioneENG = new DataExchange_Iris_Model_Data_Product_Attribute("composizione", "textarea", $configurable->composizione_eng, 3);
                $curProduct->addAttribute($composizioneENG);
                $composizioneENG = new DataExchange_Iris_Model_Data_Product_Attribute("composizione", "textarea", $configurable->composizione_eng, 4);
                $curProduct->addAttribute($composizioneENG);
            }

            //MODO USO
            if (!$this->isEmpty($configurable->modo_uso)) {
                $modo_uso = new DataExchange_Iris_Model_Data_Product_Attribute("modo_uso", "textarea", $configurable->modo_uso);
                $curProduct->addAttribute($modo_uso);
            }

            if (!$this->isEmpty($configurable->modo_uso_eng)) {
                $modo_usoENG = new DataExchange_Iris_Model_Data_Product_Attribute("modo_uso", "textarea", $configurable->modo_uso_eng, 3);
                $curProduct->addAttribute($modo_usoENG);
                $modo_usoENG = new DataExchange_Iris_Model_Data_Product_Attribute("modo_uso", "textarea", $configurable->modo_uso_eng, 4);
                $curProduct->addAttribute($modo_usoENG);
            }


            //DOSAGGIO CONSIGLIATO
            if (!$this->isEmpty($configurable->dosaggio_consigliato)) {
                $dosaggio_consigliato = new DataExchange_Iris_Model_Data_Product_Attribute("dosaggio_consigliato", "textarea", $configurable->dosaggio_consigliato);
                $curProduct->addAttribute($dosaggio_consigliato);
            }

            if (!$this->isEmpty($configurable->dosaggio_consigliato_eng)) {
                $dosaggio_consigliatoENG = new DataExchange_Iris_Model_Data_Product_Attribute("dosaggio_consigliato", "textarea", $configurable->dosaggio_consigliato_eng, 3);
                $curProduct->addAttribute($dosaggio_consigliatoENG);
                $dosaggio_consigliatoENG = new DataExchange_Iris_Model_Data_Product_Attribute("dosaggio_consigliato", "textarea", $configurable->dosaggio_consigliato_eng, 4);
                $curProduct->addAttribute($dosaggio_consigliatoENG);
            }

            //AVVERTENZE
            if (!$this->isEmpty($configurable->avvertenze)) {
                $avvertenze = new DataExchange_Iris_Model_Data_Product_Attribute("avvertenze", "textarea", $configurable->avvertenze);
                $curProduct->addAttribute($avvertenze);
            }

            if (!$this->isEmpty($configurable->avvertenze_eng)) {
                $avvertenzeENG = new DataExchange_Iris_Model_Data_Product_Attribute("avvertenze", "textarea", $configurable->avvertenze_eng, 3);
                $curProduct->addAttribute($avvertenzeENG);
                $avvertenzeENG = new DataExchange_Iris_Model_Data_Product_Attribute("avvertenze", "textarea", $configurable->avvertenze_eng, 4);
                $curProduct->addAttribute($avvertenzeENG);
            }


            //META TITLE
            if (!$this->isEmpty($configurable->meta_title)) {
                $meta_title = new DataExchange_Iris_Model_Data_Product_Attribute("meta_title", "textarea", $configurable->meta_title);
                $curProduct->addAttribute($meta_title);
            }

            if (!$this->isEmpty($configurable->meta_title_eng)) {
                $meta_titleENG = new DataExchange_Iris_Model_Data_Product_Attribute("meta_title", "textarea", $configurable->meta_title_eng, 3);
                $curProduct->addAttribute($meta_titleENG);
                $meta_titleENG = new DataExchange_Iris_Model_Data_Product_Attribute("meta_title", "textarea", $configurable->meta_title_eng, 4);
                $curProduct->addAttribute($meta_titleENG);
            }

            //META KEYWORD
            if (!$this->isEmpty($configurable->meta_keyword)) {
                $meta_keyword = new DataExchange_Iris_Model_Data_Product_Attribute("meta_keyword", "text", $configurable->meta_keyword);
                $curProduct->addAttribute($meta_keyword);
            }

            if (!$this->isEmpty($configurable->meta_keyword_eng)) {
                $meta_keywordENG = new DataExchange_Iris_Model_Data_Product_Attribute("meta_keyword", "text", $configurable->meta_keyword_eng, 3);
                $curProduct->addAttribute($meta_keywordENG);
                $meta_keywordENG = new DataExchange_Iris_Model_Data_Product_Attribute("meta_keyword", "text", $configurable->meta_keyword_eng, 4);
                $curProduct->addAttribute($meta_keywordENG);
            }

            //META DESCRIPTION
            if (!$this->isEmpty($configurable->meta_description)) {
                $meta_description = new DataExchange_Iris_Model_Data_Product_Attribute("meta_description", "textarea", $configurable->meta_description);
                $curProduct->addAttribute($meta_description);
            }

            if (!$this->isEmpty($configurable->meta_description_eng)) {
                $meta_descriptionENG = new DataExchange_Iris_Model_Data_Product_Attribute("meta_description", "textarea", $configurable->meta_description_eng, 3);
                $curProduct->addAttribute($meta_descriptionENG);
                $meta_descriptionENG = new DataExchange_Iris_Model_Data_Product_Attribute("meta_description", "textarea", $configurable->meta_description_eng, 4);
                $curProduct->addAttribute($meta_descriptionENG);
            }


            //VISIBILE ANONIMO
            // prodotto_nascosto yes|1 OPPURE no|0
            if (trim($configurable->visibile_anonimo) == "SI") {
                $prodotto_nascosto = new DataExchange_Iris_Model_Data_Product_Attribute("prodotto_nascosto", "text", "0");
                $curProduct->addAttribute($prodotto_nascosto);
            } else {
                $prodotto_nascosto = new DataExchange_Iris_Model_Data_Product_Attribute("prodotto_nascosto", "text", "1");
                $curProduct->addAttribute($prodotto_nascosto);
            }

            //BRAND
            if ($configurable->brand) {
                $collection = Mage::getModel("awshopbybrand/brand")->getCollection()->addFieldToFilter('code', $configurable->brand)->setPageSize(1);
                $brand = $collection->getFirstItem();
                $curBrand = new DataExchange_Iris_Model_Data_Product_Attribute("aw_shopbybrand_brand", "text", $brand->getId());
                $curProduct->addAttribute($curBrand);
            }

            //URL_KEY
            $url = new DataExchange_Iris_Model_Data_Product_Attribute("url_key", "text", Mage::getModel('catalog/product_url')->formatUrlKey($configurable->name));
            $curProduct->addAttribute($url);

            if ($configurable->name_eng) {
                $urlENG = new DataExchange_Iris_Model_Data_Product_Attribute("url_key", "text", Mage::getModel('catalog/product_url')->formatUrlKey($configurable->name_eng), 3);
                $curProduct->addAttribute($urlENG);
                $urlENG = new DataExchange_Iris_Model_Data_Product_Attribute("url_key", "text", Mage::getModel('catalog/product_url')->formatUrlKey($configurable->name_eng), 4);
                $curProduct->addAttribute($urlENG);
            }

            if ($configurable->category_ids) {
                $curProduct->setCategoryIds($configurable->category_ids);
            }


            $price = new DataExchange_Iris_Model_Data_Product_Attribute("price", "text", $configurable->price);
            $curProduct->addAttribute($price);

            $dal = new DataExchange_Iris_Model_Dal_Product_Default();
            $actionConfigurableId = $dal->insertData($curProduct);

            $consumer = new DataExchange_Iris_Model_Consumer_Default();
            $consumer->consumeConfigurableProductRow($actionConfigurableId);

            $this->__logCall(__METHOD__, "ended");
            return $return;
        } catch (Exception $e) {
            $this->__logCall(__METHOD__, "Exception: " . $e->getMessage(), Zend_Log::ERR);
            $return = new ReturnObject();
            $return->result_code = "Exception: " . $e->getMessage();
            return $return;
        }
    }

    public function duplicateProduct($sku) {
        try {
            $this->__setErrorHandlers();
            $this->__logCall(__METHOD__, "started");
            $return = new ReturnObject();
            $return->result_code = "SUCCESS";
            //load by sku
            $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);
            if ($product) {

                //Controllo se il duplicato esiste già
                $productToCheck = Mage::getModel('catalog/product')->loadByAttribute('sku', $product->getSku() . DataExchange_Iris_Model_Api_Resource::SUFFIX_DUPLICATED_PRODUCT);
                if ($productToCheck) {
                    $return->result_code = "ERROR: duplicated product already exists!";
                    return $return;
                }


                //controllo se lo sku è già un duplicato
                if (substr($sku, -strlen(DataExchange_Iris_Model_Api_Resource::SUFFIX_DUPLICATED_PRODUCT)) === DataExchange_Iris_Model_Api_Resource::SUFFIX_DUPLICATED_PRODUCT) {
                    $return->result_code = "ERROR: this is already a duplicated product!";
                    return $return;
                }

                //controllo se il prodotto è semplice o è configurabile
                if ($product->getTypeId() == "simple") {
                    $duplicatedProduct = $product->duplicate();
                    $duplicatedProduct = Mage::getModel('catalog/product')->load($duplicatedProduct->getId());
                    $duplicatedProduct->setSku($product->getSku() . DataExchange_Iris_Model_Api_Resource::SUFFIX_DUPLICATED_PRODUCT);
                    $duplicatedProduct->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED);
                    $duplicatedProduct->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG);
                    $duplicatedProduct->setUrlKey(Mage::getModel('catalog/product_url')->formatUrlKey($product->getUrlKey() . DataExchange_Iris_Model_Api_Resource::SUFFIX_DUPLICATED_PRODUCT));
                    $duplicatedProduct->setScadenzaBreve(1);
                    $duplicatedProduct->setProductExpiration($product->getSku());

                    //imposto l'attributo tipo_promozione
                    $duplicatedProduct->setData("promotion_type", "173");
                    $baseDir = Mage::getBaseDir('media') . DS . "catalog/product";
                    $curImage = $product->getData("image");
                    if($curImage){
                        $duplicatedProduct->addImageToMediaGallery($baseDir.$curImage, array('image', 'small_image', 'thumbnail'), false, false);
                    }

                    $duplicatedProduct->save();

                    //salvo attributo product_expiration nel prodotto non in scadenza
                    Mage::getSingleton('catalog/product_action')->updateAttributes(array($product->getId()), array("product_expiration" => $duplicatedProduct->getSku()), 0);

                    $return->result_data = "Sku_duplicated: " . $duplicatedProduct->getSku();
                } else {
                    $originalProductConfigurable = $product;


                    $attributes = $originalProductConfigurable->getTypeInstance(true)->getConfigurableAttributesAsArray($originalProductConfigurable);
                    $attributeString = "";
                    foreach ($attributes as $att) {
                        $attributeString .= $att["attribute_code"] . ",";
                    }
                    $configurableAttributes = trim($attributeString, ",");

                    echo $attributeString;

                    $childProducts = Mage::getModel('catalog/product_type_configurable')->getChildrenIds($product->getId());

                    $newChildProducts = array();
                    //duplico i prodotti semplici
                    foreach ($childProducts[0] as $childId) {
                        $simpleProductToDuplicate = Mage::getModel("catalog/product")->load($childId);
                        $duplicatedProduct = $simpleProductToDuplicate->duplicate();
                        $duplicatedProduct = Mage::getModel('catalog/product')->load($duplicatedProduct->getId());
                        $duplicatedProduct->setSku($simpleProductToDuplicate->getSku() . DataExchange_Iris_Model_Api_Resource::SUFFIX_DUPLICATED_PRODUCT);
                        $duplicatedProduct->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED);
                        $duplicatedProduct->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE);
                        $duplicatedProduct->setUrlKey(Mage::getModel('catalog/product_url')->formatUrlKey($simpleProductToDuplicate->getUrlKey() . DataExchange_Iris_Model_Api_Resource::SUFFIX_DUPLICATED_PRODUCT));
                        $duplicatedProduct->setScadenzaBreve(1);
                        $duplicatedProduct->setProductExpiration($simpleProductToDuplicate->getSku());

                        $duplicatedProduct->save();
                        $newChildProducts[] = $duplicatedProduct->getId();
                    }




                    $simpleSkuCollection = Mage::getModel("catalog/product")->getCollection()->addAttributeToFilter('entity_id', array('in' => $newChildProducts));


                    Mage::helper("iris/product")->duplicateConfigurableProduct($originalProductConfigurable, $simpleSkuCollection, $configurableAttributes, "_sc");
                }
            } else {
                $return->result_code = "Prodotto non trovato!";
            }

            $this->__logCall(__METHOD__, "ended");
            return $return;
        } catch (Exception $e) {
            $this->__logCall(__METHOD__, "Exception: " . $e->getMessage(), Zend_Log::ERR);
            $this->__logCall(__METHOD__, $e->getTraceAsString(), Zend_Log::ERR);
            $return = new ReturnObject();
            $return->result_code = "Exception: " . $e->getMessage();
            return $return;
        }
    }

    public function importBrand($brand) {
        try {
            Mage::helper("iris/log")->log($brand);

            $this->__setErrorHandlers();
            $this->__logCall(__METHOD__, "started");
            $return = new ReturnObject();
            $return->result_code = "SUCCESS";


            $brands = Mage::getModel('awshopbybrand/brand')->getCollection()->addFieldToFilter("code", $brand->code);

            if ($brands->count() > 0) {
                $return->result_code = DataExchange_Iris_Model_Api_Resource::BRAND_ALREADY_EXISTS;
                $this->__logCall(__METHOD__, DataExchange_Iris_Model_Api_Resource::BRAND_ALREADY_EXISTS, Zend_Log::ERR);
                return $return;
            }

            $brandModel = Mage::getModel("awshopbybrand/brand");
            $brandModel->setData("code", $brand->code);
            $brandModel->setData("title", $brand->title);
            $brandModel->setData("title_eng", $brand->title_eng);
            $brandModel->setData("store_ids", "0");
            $brandModel->setData("brand_status", "0");
            $brandModel->setData("url_key", strtolower($brand->name));
            $brandModel->setData("description", $brand->description);
            $brandModel->setData("description_eng", $brand->description_eng);
            $brandModel->setData("meta_description", $brand->meta_description);
            $brandModel->setData("meta_description_eng", $brand->meta_description_eng);
            $brandModel->setData("name", $brand->name);

            $fasciaSconto = Mage::getModel("fascesconto/fascia")->getCollection()->addFieldToFilter("name", $brand->fascia_sconto)->getFirstItem();
            if ($fasciaSconto->getId()) {
                $brandModel->setData("fascia_sconto", $fasciaSconto->getId());
            }

            $path = 'aw_shopbybrand' . DS . "image" . DS;
            $imageName = $path . $brand->immagine;


            $brandModel->setData("image", $imageName);

            Mage::helper("iris/log")->log("Importo brand " . $brand->name);
            $brandModel->save();


            $this->__logCall(__METHOD__, "ended");
            return $return;
        } catch (Exception $e) {
            $this->__logCall(__METHOD__, "Exception: " . $e->getMessage(), Zend_Log::ERR);
            $return = new ReturnObject();
            $return->result_code = "Exception: " . $e->getMessage();
            return $return;
        }
    }

    private function __updateStockExpiry($productId, $qty, $expiry) {
        //2)aggiorno lo stock
        if ($qty != null && trim($qty) != "") {
            Mage::helper("iris/inventory")->updateProductInventory($productId, $qty);
        }
        //3)aggiorno la scadenza 
        if ($expiry != null && trim($expiry) != "") {
            if (Mage::helper("iris/validation")->validateInput($expiry, "date")) {
                Mage::helper("iris/product")->updateAttributeNoChecks($productId, DataExchange_Iris_Model_Api_Resource::EXPIRY_ATTRIBUTE, $expiry, 0);
            } else {
                $this->__logCall(__METHOD__, DataExchange_Iris_Model_Api_Resource::WS_VALIDATION_ERROR_DATE . " - value: " . $expiry, Zend_Log::ERR);
            }
        }
    }

    public function importStockExpiry($sku, $dispInScadenza, $dataInScadenza, $dispNonScadenza, $dataNonScadenza) {
        try {
            $this->__setErrorHandlers();
            $this->__logCall(__METHOD__, "started");
            $return = new ReturnObject();
            $return->result_code = "SUCCESS";


            $returnMessage = "";
            //1)carico lo sku non in scadenza
            $product_id = Mage::getModel('catalog/product')->getIdBySku($sku);
            $product = Mage::getModel("catalog/product")->load($product_id);
            if (!$product || $product->getTypeId() != "simple") {
                $returnMessage .= $sku . " not found or sku is configurable! - ";
            } else {
                $this->__updateStockExpiry($product->getId(), $dispNonScadenza, $dataNonScadenza);
            }


            //1)carico lo sku in scadenza
            $skuScadenza = $sku . DataExchange_Iris_Model_Api_Resource::SUFFIX_DUPLICATED_PRODUCT;
            $product_idSc = Mage::getModel('catalog/product')->getIdBySku($skuScadenza);
            if ($product_idSc) {
                $productScadenza = Mage::getModel("catalog/product")->load($product_idSc);
                if (!$productScadenza || $product->getTypeId() != "simple") {
                    $returnMessage .= $skuScadenza . " or sku is configurable! - ";
                } else {
                    $this->__updateStockExpiry($productScadenza->getId(), $dispInScadenza, $dataInScadenza);
                }
            }

            if ($returnMessage != "") {
                $return->result_data = $returnMessage;
            }
            $this->__logCall(__METHOD__, "ended");
            return $return;
        } catch (Exception $e) {
            $this->__logCall(__METHOD__, "Exception: " . $e->getMessage(), Zend_Log::ERR);
            $return = new ReturnObject();
            $return->result_code = "Exception: " . $e->getMessage();
            return $return;
        }
    }

    public function exportStockExpiry($sku = null) {
        try {
            $this->__setErrorHandlers();
            $this->__logCall(__METHOD__, "started");
            $return = new ExportStocks();
            $return->result_code = "SUCCESS";

            if ($sku) {
                //esporto un singolo sku
                $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);
                if ($product) {
                    $stock = new ExportStock();
                    $stock->expiry = $product->getData(DataExchange_Iris_Model_Api_Resource::EXPIRY_ATTRIBUTE);
                    $stock->qty = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getQty();
                    $return->exportStocksArray[] = $stock;
                }
            } else {
                //esporto tutti gli sku
                $collectionSimple = Mage::getResourceModel('catalog/product_collection')->addAttributeToSelect(DataExchange_Iris_Model_Api_Resource::EXPIRY_ATTRIBUTE)->addAttributeToFilter('type_id', array('eq' => 'simple'));
                foreach ($collectionSimple as $product) {
                    $stock = new ExportStock();
                    $stock->expiry = $product->getData(DataExchange_Iris_Model_Api_Resource::EXPIRY_ATTRIBUTE);
                    $stock->qty = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getQty();
                    $return->exportStocksArray[] = $stock;
                }
            }


            $this->__logCall(__METHOD__, "ended");
            return $return;
        } catch (Exception $e) {
            $this->__logCall(__METHOD__, "Exception: " . $e->getMessage(), Zend_Log::ERR);
        }
    }

    public function updateOrderStatus($orderId, $status) {
        try {
            $this->__setErrorHandlers();
            $this->__logCall(__METHOD__, "started");
            $return = new ReturnObject();
            $return->result_code = "SUCCESS";

            $validOrderStatuses = array("complete", "canceled","ordine_scaricato_mago","ordine_assegnato","ordine_piccato");

            if (!in_array($status, $validOrderStatuses)) {
                $return->result_code = "Invalid order status: " . $status;
                return $return;
            }

            switch ($status) {
                case "complete":
                    if (!Mage::helper("iris/order")->updateOrderStatus($orderId, $status)) {
                        $return->result_code = "Could not update order " . $orderId . " with status " . $status;
                    }
                    break;
                case "canceled":
                    $orderModel = Mage::getModel('sales/order');
                    $order = $orderModel->load($orderId);
                    if (!$order->canCancel()) {
                        Mage::helper("iris/order")->createCreditMemo($orderId);
                    } else {
                        $orderModel->cancel();
                    }
                default:
                    if (!Mage::helper("iris/order")->updateOrderStatus($orderId, $status)) {
                        $return->result_code = "Could not update order " . $orderId . " with status " . $status;
                    }
                    break;
            }
            $this->__logCall(__METHOD__, "ended");
            return $return;
        } catch (Exception $e) {
            $this->__logCall(__METHOD__, "Exception: " . $e->getMessage(), Zend_Log::ERR);
            $return = new ReturnObject();
            $return->result_code = "Exception: " . $e->getMessage();
            return $return;
        }
    }

    public function createShipment($orderIncrementId, $shipmentTrackingNumber, $customerEmailComments, $shipmentCarrierCode, $shipmentCarrierTitle, $send_email = false) {
        try {
            $this->__setErrorHandlers();
            $this->__logCall(__METHOD__, "started");
            $return = new ReturnObject();
            $return->result_code = "SUCCESS";

            Mage::helper("iris/order")->completeShipment($orderIncrementId, $shipmentTrackingNumber, $customerEmailComments, $shipmentCarrierCode, $shipmentCarrierTitle, $send_email);

            $this->__logCall(__METHOD__, "ended");
            return $return;
        } catch (Exception $e) {
            $this->__logCall(__METHOD__, "Exception: " . $e->getMessage(), Zend_Log::ERR);
            $return = new ReturnObject();
            $return->result_code = "Exception: " . $e->getMessage();
            return $return;
        }
    }

    private function __updateProductLabel($sku, $label) {
        $validArray = array("normal" => "", "new" => "175", "promo" => "174", "lastminute" => "173");
        //check if label is present in array
        if (array_key_exists($label, $validArray)) {
            $productId = Mage::getModel("catalog/product")->getIdBySku($sku);
            if ($productId) {
                Mage::getSingleton('catalog/product_action')->updateAttributes(array($productId), array("promotion_type" => $validArray[$label]), 0);
                Mage::helper("iris/log")->log("updating label for productId " . $productId . " with value " . $validArray[$label]);
                return true;
            }
        }
        return false;
    }

    public function updateLabels($labelsUpdate) {
        try {
            $this->__setErrorHandlers();
            $this->__logCall(__METHOD__, "started");
            $return = new ReturnObject();
            $return->result_code = "SUCCESS";


            foreach ($labelsUpdate->labels as $label) {
                if (isset($label->sku) && isset($label->label)) {
                    $updateResult = $this->__updateProductLabel($label->sku, $label->label);
                    if (!$updateResult) {
                        $return->result_code = "SOME LABELS NOT UPDATED";
                    }
                }
            }

            $this->__logCall(__METHOD__, "ended");
            return $return;
        } catch (Exception $e) {
            $this->__logCall(__METHOD__, "Exception: " . $e->getMessage(), Zend_Log::ERR);
            $return = new ReturnObject();
            $return->result_code = "Exception: " . $e->getMessage();
            return $return;
        }
    }

    public function skusForLabel($label) {
        $validArray = array("normal" => "", "new" => "175", "promo" => "174", "lastminute" => "173");
        try {
            $this->__setErrorHandlers();
            $this->__logCall(__METHOD__, "started");

            $labels = new LabelsUpdate();
            $labels->labels = array();
            //controllo se la label è nell'array
            if (!array_key_exists($label, $validArray)) {
                $return->result_code = "LABEL NOT VALID";
                $this->__logCall(__METHOD__, "ended");
                return $return;
            }
            //prendo le labels con quella etichetta
            $productCollection = Mage::getModel("catalog/product")->getCollection()
                    ->addAttributeToSelect("sku")
                    ->addAttributeToSelect("promotion_type")
                    ->addFieldToFilter("promotion_type", array("eq" => $validArray[$label]));

            foreach ($productCollection as $product) {
                $curLabel = new Label();
                $curLabel->sku = $product->getSku();
                $curLabel->label = $label;
                $labels->labels[] = $curLabel;
            }

            $this->__logCall(__METHOD__, "ended");
            return $labels;
        } catch (Exception $e) {
            $this->__logCall(__METHOD__, "Exception: " . $e->getMessage(), Zend_Log::ERR);
        }
    }

    public function changeGroup($email, $groupname, $type) {
        try {
            $this->__setErrorHandlers();
            $this->__logCall(__METHOD__, "started");
            $return = new ReturnObject();
            $return->result_code = "SUCCESS";

            if ($type != "B2C" && $type != "B2B") {
                $return->result_code = "TYPE NOT VALID";
                $this->__logCall(__METHOD__, "ended");
                return $return;
            }

            $customer = Mage::getModel("customer/customer");
            if ($type == "B2C") {
                $customer->setWebsiteId(1);
            } else if ($type == "B2B") {
                $customer->setWebsiteId(2);
            }
            $customer = $customer->loadByEmail($email);
            if (!$customer->getId()) {
                $return->result_code = "USER NOT VALID";
                $this->__logCall(__METHOD__, "ended");
                return $return;
            }
            
            //controllo se il customer è ha l'avanzamento gruppo bloccato
            if($customer->getData("avanzamento_gruppo_bloccato") == 1){
                $return->result_code = "GROUP BLOCKED FOR THIS USER";
                $this->__logCall(__METHOD__, "ended");
                return $return;                
            }

            $validGroups = array();
            $groups = Mage::getModel("customer/group")->getCollection();
            foreach ($groups as $group) {
                //Mage::helper("iris/log")->log($group);
                $validGroups[$group->getCode()] = $group->getId();
            }
//            Mage::helper("iris/log")->log("valid groups:");
//            Mage::helper("iris/log")->log($validGroups);
            //controllo se il gruppo esiste
            if (!array_key_exists($groupname, $validGroups)) {
                $return->result_code = "GROUP NOT VALID";
                $this->__logCall(__METHOD__, "ended");
                return $return;
            }


            if ($validGroups[$groupname]) {
                Mage::helper("iris/log")->log("Salvo utente " . $email . " con gruppo " . $groupname);
                $customer->setGroupId($validGroups[$groupname]);
                $customer->save();
            }

            $this->__logCall(__METHOD__, "ended");
            return $return;
        } catch (Exception $e) {
            $this->__logCall(__METHOD__, "Exception: " . $e->getMessage(), Zend_Log::ERR);
            $return = new ReturnObject();
            $return->result_code = "Exception: " . $e->getMessage();
            return $return;
        }
    }

    public function productsExists($skus) {
        try {
            $this->__setErrorHandlers();
            $this->__logCall(__METHOD__, "started");

            foreach ($skus->skus as $skuExist) {
                if (Mage::getModel('catalog/product')->getIdBySku($skuExist->sku)) {
                    $skuExist->exist = "true";
                } else {
                    $skuExist->exist = "false";
                }
            }
            $this->__logCall(__METHOD__, "ended");
            return $skus;
        } catch (Exception $e) {
            $this->__logCall(__METHOD__, "Exception: " . $e->getMessage(), Zend_Log::ERR);
        }
    }

    public function importSimpleProductForConfigurable($simple, $configurablesku) {
        try {
            $this->__setErrorHandlers();
            $this->__logCall(__METHOD__, "started");
            $return = new ReturnObject();
            $return->result_code = "SUCCESS";

            $configurableId = Mage::getModel("catalog/product")->getIdBySku($configurablesku);
            if (!$configurableId) {
                $return = new ReturnObject();
                $return->result_code = "Problem loading configurable!";
                return $return;
            }

            $configurable = Mage::getModel("catalog/product")->load($configurableId);

            Mage::helper("iris/log")->log($simple);

            $curProduct = new DataExchange_Iris_Model_Data_Product_Default();
            $curProduct->setSku($simple->sku);
            $curProduct->setSource("webservice");
            $curProduct->setProductType(Mage_Catalog_Model_Product_Type::TYPE_SIMPLE);

            $curProduct->setAttributeSetId(DataExchange_Iris_Model_Data_Product_Default::ATTRIBUTE_SET_ID_DEFAULT);
            //$curProduct->setWebsiteIds(DataExchange_Iris_Model_Data_Product_Default::WEBSITE_IDS_DEFAULT);
            $curProduct->setWebsiteIds("1,2");

            //taxClass
            //21 id 2
            //10 id 5
            //4 id 6
            if ($simple->iva == "10") {
                $curProduct->setTaxClass(5);
            } else if ($simple->iva == "04") {
                $curProduct->setTaxClass(6);
            } else {
                $curProduct->setTaxClass(2);
            }
            //$curProduct->setTaxClass(DataExchange_Iris_Model_Data_Product_Default::TAX_CLASS_DEFAULT);
            $curProduct->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE);
            $curProduct->setProductStatus(DataExchange_Iris_Model_Data_Product_Default::STATUS_ENABLED);




            $curProduct->setName($simple->name);

            $price = new DataExchange_Iris_Model_Data_Product_Attribute("price", "text", $simple->price);
            $curProduct->addAttribute($price);

            //aggiunta nuovi attributi
            //
            //vetrine inglesi id: 3,4
            //WEIGHT
            $weight = new DataExchange_Iris_Model_Data_Product_Attribute("weight", "text", $simple->weight);
            $curProduct->addAttribute($weight);

            $configurableAttributes = array();
            $productAttributeOptions = $configurable->getTypeInstance(true)->getConfigurableAttributesAsArray($configurable);

            foreach ($productAttributeOptions as $atConf) {
                $configurableAttributes[] = $atConf["attribute_code"];
            }

            foreach ($simple->attributeArray as $simpleAttr) {
                if (in_array($simpleAttr->attributeCode, $configurableAttributes)) {
                    $attr = new DataExchange_Iris_Model_Data_Product_Attribute($simpleAttr->attributeCode, "select", $simpleAttr->attributeValue);
                    $curProduct->addAttribute($attr);
                }
            }



            $dal = new DataExchange_Iris_Model_Dal_Product_Default();
            $actionId = $dal->insertData($curProduct);

            $consumer = new DataExchange_Iris_Model_Consumer_Default();
            $consumer->consumeSimpleProductRow($actionId);


            //dopo avere creato il prodotto semplice prendo la lista dei semplice del configurabile in questione ed aggiungo il nuovo prodotto creato
            $simpleSkuArray = array();

            $conf = Mage::getModel('catalog/product_type_configurable')->setProduct($configurable);
            $simple_collection = $conf->getUsedProductCollection()->addAttributeToSelect('sku');
            foreach ($simple_collection as $simple_product) {
                $simpleSkuForArray = $simple_product->getSku();
                if (!in_array($simpleSkuForArray, $simpleSkuArray)) {
                    $simpleSkuArray[] = $simpleSkuForArray;
                }
            }

            if (!in_array($simple->sku, $simpleSkuArray)) {
                $simpleSkuArray[] = $simple->sku;
            }

            Mage::helper("iris/product")->updateConfigurableProduct($configurable->getSku(), $simpleSkuArray);

            $this->__logCall(__METHOD__, "ended");
            return $return;
        } catch (Exception $e) {
            $this->__logCall(__METHOD__, "Exception: " . $e->getMessage(), Zend_Log::ERR);
            $return = new ReturnObject();
            $return->result_code = "Exception: " . $e->getMessage();
            return $return;
        }
    }

    private function isEmpty($field) {
        if (empty($field)) {
            return true;
        } else {
            return false;
        }
    }
    
    
    public function linkConfigurable($skuconfigurable,$skussimple) {
        try {
            $this->__setErrorHandlers();
            $this->__logCall(__METHOD__, "started");
            
            $return = new ReturnObject();
            $return->result_code = "SUCCESS";
            
            Mage::helper("iris/product")->updateConfigurableProduct($skuconfigurable, $skussimple);            
            $this->__logCall(__METHOD__, "ended");
            return $return;
        } catch (Exception $e) {
            $this->__logCall(__METHOD__, "Exception: " . $e->getMessage(), Zend_Log::ERR);
        }
    }

}

?>