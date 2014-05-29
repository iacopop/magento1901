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
                    $currentExportArray->price = $product->getFinalPrice();
                    $return->exportPricesArray[] = $currentExportArray;
                }
            }

            $this->__logCall(__METHOD__, "ended");
            return $return;
        } catch (Exception $e) {
            $this->__logCall(__METHOD__, "Exception: " . $e->getMessage(), Zend_Log::ERR);
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
            $curProduct->setTaxClass(DataExchange_Iris_Model_Data_Product_Default::TAX_CLASS_DEFAULT);
            $curProduct->setVisibility(DataExchange_Iris_Model_Data_Product_Default::VISIBILITY_DEFAULT);
            $curProduct->setProductStatus(DataExchange_Iris_Model_Data_Product_Default::STATUS_DISABLED);


            $name = new DataExchange_Iris_Model_Data_Product_Attribute("name", "text", $simple->name);
            $curProduct->addAttribute($name);

            $price = new DataExchange_Iris_Model_Data_Product_Attribute("price", "text", $simple->price);
            $curProduct->addAttribute($price);

            $dal = new DataExchange_Iris_Model_Dal_Product_Default();
            $actionId = $dal->insertData($curProduct);

            $consumer = new DataExchange_Iris_Model_Consumer_Default();
            $consumer->consumeSimpleProductRow($actionId);

            $this->__logCall(__METHOD__, "ended");
            return $return;
        } catch (Exception $e) {
            $this->__logCall(__METHOD__, "Exception: " . $e->getMessage(), Zend_Log::ERR);
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
                $simpleProduct->setTaxClass(DataExchange_Iris_Model_Data_Product_Default::TAX_CLASS_DEFAULT);
                $simpleProduct->setVisibility(DataExchange_Iris_Model_Data_Product_Default::VISIBILITY_DEFAULT);
                $simpleProduct->setProductStatus(DataExchange_Iris_Model_Data_Product_Default::STATUS_ENABLED);
                $simpleProduct->setParentSku($configurable->sku);
                $simpleProduct->setName($simple->name);


                //$name = new DataExchange_Iris_Model_Data_Product_Attribute("name", "text", $simple->name);
                //$simpleProduct->addAttribute($name);            

                $price = new DataExchange_Iris_Model_Data_Product_Attribute("price", "text", $simple->price);
                $simpleProduct->addAttribute($price);

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
            $curProduct->setTaxClass(DataExchange_Iris_Model_Data_Product_Default::TAX_CLASS_DEFAULT);
            $curProduct->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH);
            $curProduct->setProductStatus(DataExchange_Iris_Model_Data_Product_Default::STATUS_DISABLED);
            $curProduct->setConfigurableAttributes($configurable->configurableAttributes);
            $curProduct->setName($configurable->name);

            //$name = new DataExchange_Iris_Model_Data_Product_Attribute("name", "text", $configurable->name);
            //$curProduct->addAttribute($name);            

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
                    $duplicatedProduct->setStatus(Mage_Catalog_Model_Product_Status::STATUS_DISABLED);
                    $duplicatedProduct->setVisibility($product->getVisibility());
                    $duplicatedProduct->setUrlKey(Mage::getModel('catalog/product_url')->formatUrlKey($product->getUrlKey() . DataExchange_Iris_Model_Api_Resource::SUFFIX_DUPLICATED_PRODUCT));
                    $duplicatedProduct->setScadenzaBreve(1);
                    $duplicatedProduct->setProductExpiration($product->getSku());

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

                    $childProducts = Mage::getModel('catalog/product_type_configurable')->getChildrenIds(3353);

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
        }
    }

    public function importBrand($brand) {
        try {
            Mage::helper("iris/log")->log($brand);

            $this->__setErrorHandlers();
            $this->__logCall(__METHOD__, "started");
            $return = new ReturnObject();
            $return->result_code = "SUCCESS";


            $brands = Mage::getModel('awshopbybrand/brand')->getCollection()->addFieldToFilter("name", $brand->name);

            if ($brands->count() > 0) {
                $return->result_code = DataExchange_Iris_Model_Api_Resource::BRAND_ALREADY_EXISTS;
                $this->__logCall(__METHOD__, DataExchange_Iris_Model_Api_Resource::BRAND_ALREADY_EXISTS, Zend_Log::ERR);
                return $return;
            }

            $brandModel = Mage::getModel("awshopbybrand/brand");
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


            //1)carico lo sku non in scadenza
            $skuScadenza = $sku . DataExchange_Iris_Model_Api_Resource::SUFFIX_DUPLICATED_PRODUCT;
            $product_idSc = Mage::getModel('catalog/product')->getIdBySku($skuScadenza);
            $productScadenza = Mage::getModel("catalog/product")->load($product_idSc);
            if (!$productScadenza || $product->getTypeId() != "simple") {
                $returnMessage .= $skuScadenza . " or sku is configurable! - ";
            } else {
                $this->__updateStockExpiry($productScadenza->getId(), $dispInScadenza, $dataInScadenza);
            }

            if ($returnMessage != "") {
                $return->result_data = $returnMessage;
            }
            $this->__logCall(__METHOD__, "ended");
            return $return;
        } catch (Exception $e) {
            $this->__logCall(__METHOD__, "Exception: " . $e->getMessage(), Zend_Log::ERR);
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

            $validOrderStatuses = array("complete");

            if (!in_array($status, $validOrderStatuses)) {
                $return->result_code = "Invalid order status: " . $status;
                return $return;
            }

            if (!Mage::helper("iris/order")->updateOrderStatus($orderId, $status)) {
                $return->result_code = "Could not update order " . $orderId . " with status " . $status;
            }

            $this->__logCall(__METHOD__, "ended");
            return $return;
        } catch (Exception $e) {
            $this->__logCall(__METHOD__, "Exception: " . $e->getMessage(), Zend_Log::ERR);
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
        }
    }

}

?>