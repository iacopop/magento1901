<?php

class DataExchange_Iris_Helper_Product {
//1 not visible individually, 4 catalog, search

    const SIMPLE_VISIBILITY = 1;
    const CONFIGURABLE_VISIBILITY = 4;
    const SIMPLE_STATUS_ENABLED = 1;
    const CONFIGURABLE_STATUS = 1;
    const SIMPLE_TAXCLASSID = 2;
    const CONFIGURABLE_TAXCLASSID = 2;
    const SIMPLE_ATTRIBUTESETID = 4;
    const CONFIGURABLE_ATTRIBUTESETID = 4;
    const STOCK_CONFIGURATION = 'iris_inventory/settings/stock';
    const DEFAULT_STOCK_CONFIGURATION = 'iris_inventory/settings/default_stock';

    public $WEBSITE_ARRAY = array(1);
    public $attribute_array_entity = array();
    public $attribute_values_array = array();

    //se true i prodotti semplici sono con stock, se false no.

    const SIMPLE_HAS_STOCK = true;

    public $att_color = null;
    public $att_size = null;
    public $color_val = null;
    public $size_val = null;

    /**
     * @param type $row
     * @return boolean True se i dati sono validi, false altrimenti
     */
    function __checkSingleRowData($row) {
        return true;
    }

    function __reindexAll() {
        for ($i = 1; $i <= 9; $i++) {
            $process = Mage::getModel('index/process')->load($i);
            $process->reindexAll();
        }
    }

    /**
     * Controlla se l'attributo è usabile per i configurabili e di ambito globale
     * @param type $attribute_code
     * @return boolean
     */
    function __checkAttributeIsConfigurable($attribute_code) {
        $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attribute_code);
        if ($attribute->getData("is_global") == "1" && $attribute->getData("is_configurable") == "1") {
            return true;
        } else {
            return false;
        }
    }

    function __log($message) {
        Mage::helper("iris/log")->log($message);
    }

    /**
     * Ottiene la lista delle opzioni di un attributo (codice)
     * @param <type> $option
     * @return <type>
     */
    public function __getAttList($option) {
        $attributes = Mage::getResourceModel('eav/entity_attribute_collection')
                ->addFieldToFilter('attribute_code', $option)
                ->load(false);
        $attribute = $attributes->getFirstItem();
        $attribute->setSourceModel('eav/entity_attribute_source_table');
        $atts = $attribute->getSource()->getAllOptions(false);
        $result = array();
        foreach ($atts as $tmp)
            $result[$tmp['label']] = $tmp['value'];
        return $result;
    }

    public function checkAttributeType($attribute_code, $attribute_type, $attribute_value) {
        $this->__log("check attribute " . $attribute_code . " - " . $attribute_type . " - " . $attribute_value);
        switch ($attribute_type) {
            case "text":
                return $attribute_value;
                break;
            case "textarea":
                return $attribute_value;
                break;
            case "select":
                if (!Mage::helper("iris/attribute")->getAttributeOptionValue($attribute_code, $attribute_value)) {
                    Mage::helper("iris/attribute")->addAttributeOption($attribute_code, $attribute_value);
                }
                return Mage::helper("iris/attribute")->getAttributeOptionValue($attribute_code, $attribute_value);
                break;
            case "multiselect":
                $returnValue = "";
                $valuesArray = explode(",", trim($attribute_value, ","));
                foreach ($valuesArray as $value) {
                    if (!Mage::helper("iris/attribute")->getAttributeOptionValue($attribute_code, $value)) {
                        Mage::helper("iris/attribute")->addAttributeOption($attribute_code, $value);
                        $returnValue .= "," . Mage::helper("iris/attribute")->getAttributeOptionValue($attribute_code, $value);
                    } else {
                        $returnValue .= "," . Mage::helper("iris/attribute")->getAttributeOptionValue($attribute_code, $value);
                    }
                }
                return trim($returnValue, ",");
                break;
            case "price":
                return $attribute_value;
                break;
            default:
                return $attribute_value;
                break;
        }
        return $attribute_value;
    }

    /**
     * Questa funzione aggiorna l'attributo nella store view corretta.
     * La funzione controlla se l'attributo esiste altrimenti lo crea.
     * La funzione controlla se l'attributo (in caso di select, multiselect) ha il valore e se non lo ha, lo crea.
     * @param type $product_id
     * @param type $attribute_code
     * @param type $attribute_value
     * @param type $store_id
     */
    public function updateAttribute($product_id, $attribute_code, $attribute_type, $attribute_value, $store_id) {
        //controllo se attribute e valore ci sono
        if (
                trim($attribute_code) == "" || $attribute_code == null ||
                trim($attribute_type) == "" || $attribute_type == null ||
                trim($attribute_value) == "" || $attribute_value == null
        ) {
            $this->__log("EMPTY ATTRIBUTE: " . $attribute_code);
            return;
        }

        //controllo se l'attributo esiste altrimenti lo creo
        $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', $attribute_code);
        if (!$attribute->getId()) {
            $this->__log("creating attribute " . $attribute_code . " di tipo " . $attribute_type);
            Mage::helper("iris/attribute")->createProductAttribute($attribute_code, $attribute_type);
        }

        //Prima di andare a scrivere il valore dell'attributo si controlla di che tipo è ed in caso si crea l'opzione corretta
        $rightAttributeValue = $this->checkAttributeType($attribute_code, $attribute_type, $attribute_value);

        //controllo se il valore è vuoto
        if ($rightAttributeValue != "" && $rightAttributeValue != null) {
            Mage::getSingleton('catalog/product_action')->updateAttributes(array($product_id), array($attribute_code => $rightAttributeValue), $store_id);
            $this->__log("Updating product: " . $product_id . " - " . $attribute_code . " - " . $rightAttributeValue . " - " . $store_id);
        }
    }

    /**
     * Questa funzione aggiorna l'attributo nella store view corretta.
     * @param type $product_id
     * @param type $attribute_code
     * @param type $attribute_value
     * @param type $store_id
     */
    public function updateAttributeNoChecks($product_id, $attribute_code, $attribute_value, $store_id) {
        //controllo se attribute e valore ci sono
        if (
                trim($attribute_code) == "" || $attribute_code == null ||
                trim($attribute_value) == "" || $attribute_value == null
        ) {
            $this->__log("EMPTY ATTRIBUTE: " . $attribute_code);
            return;
        }

        Mage::getSingleton('catalog/product_action')->updateAttributes(array($product_id), array($attribute_code => $attribute_value), $store_id);
        $this->__log("Updating attribute: product_id: " . $product_id . " - attr: " . $attribute_code . " - value: " . $attribute_value . " - store_id: " . $store_id);
    }

    /**
     * Prende una lista di attributi e ritorna una array di array. Ogni sotto array è una vista da aggiornare
     * @param DataExchange_Iris_Model_Mysql4_Action_Product_Attribute_Collection $attributeArray
     */
    public function getFormatAttributeArrays(DataExchange_Iris_Model_Mysql4_Action_Product_Attribute_Collection $attributeArray) {
        $returnArray = array();
        foreach ($attributeArray as $attribute) {
            $returnArray[$attribute->getStoreId()][] = $attribute;
        }
        ksort($returnArray);
        return $returnArray;
    }

    /**
     * Crea il prodotto con gli attributi base e con quelli aggiuntivi per le store view
     * @param type $row è un oggetto di tipo DataExchange_Iris_Model_Data_Product_Default
     * @param type $attributeArray oggetto di tipo DataExchange_Iris_Model_Data_Product_Attribute
     * @return type
     * @throws Exception
     */
    function insertSingleProduct(
    DataExchange_Iris_Model_Action_Product $row, DataExchange_Iris_Model_Mysql4_Action_Product_Attribute_Collection $attributeArray) {

        $productOne = Mage::getModel('catalog/product');


        if ($productOne->getIdBySku($row->getSku())) {
            throw new Exception("Product already exist! Sku: " . $row->getSku());
        }
        
        $productOne->setName($row->getName());
        $websiteArray = explode(",", trim($row->getWebsiteIds(), ","));
        $productOne->setWebsiteIds($websiteArray);
        $productOne->setVisibility($row->getVisibility());
        $productOne->setStatus($row->getProductStatus());
        $productOne->setTaxClassId($row->getTaxClass()); //taxable goods
        $productOne->setSku($row->getSku());
        $productOne->setTypeId($row->getProductType());
        $productOne->setAttributeSetId($row->getAttributeSetId());
        $productOne->setUseDefault(1);
        $productOne->setCreatedAt(strtotime('now'));
        if($row->getCategoryIds()){
            $productOne->setCategoryIds($row->getCategoryIds());
        }

        if (Mage::getStoreConfig(self::STOCK_CONFIGURATION)) {
            $productOne->setStockData(array(
                'is_in_stock' => Mage_CatalogInventory_Model_Stock_Status::STATUS_IN_STOCK,
                'qty' => Mage::getStoreConfig(self::DEFAULT_STOCK_CONFIGURATION)
            ));
        } else {
            $productOne->setStockData(array(
                'is_in_stock' => Mage_CatalogInventory_Model_Stock_Status::STATUS_OUT_OF_STOCK,
                'qty' => 0
            ));
        }

        try {
            $this->__log("----------- Salvataggio prodotto semplice " . $row->getSku() . " -----------");
            $createdProduct = $productOne->save();

            if ($createdProduct->getId()) {

                //ciclo tutte le store view aggiornando attributi; parto da quella globale ovvero la store view con id 0
                $attributeFormattedArray = $this->getFormatAttributeArrays($attributeArray);

                foreach ($attributeFormattedArray as $key => $attributeCurrentArray) {
                    foreach ($attributeCurrentArray as $attribute) {
                        //aggiorno l'attributo
                        $this->updateAttribute($createdProduct->getId(), $attribute->getAttributeCode(), $attribute->getType(), $attribute->getValue(), $attribute->getStoreId());
                    }
                }
            }
        } catch (Exception $e) {
            $this->__log("Errore: " . $e->getMessage());
        }

        return $productOne;
    }

    /*
     * Configurable = il prodotto configurabile (i dati)
     * l'array di attributi configurabili tipo: array("attribute_code1","attribute_code2","attribute_code3"....)
     */

    protected function _getSimpleCollectionForConfigurable($configurable) {

        return Mage::getModel('iris/action_product')->getCollection()
                        ->addFieldToFilter('parent_sku', $configurable->getParentSku());
    }

    protected function _getMinimalPriceForConfigurable($simpleCollection) {
        $prices = array();

        foreach ($simpleCollection as $simple) {
            $attributeCollection = $simple->getAttributesCollection()
                    ->addFieldToFilter('store_id', 0)
                    ->addFieldToFilter('attribute_code', 'price');

            foreach ($attributeCollection as $attribute) {
                $prices[] = $attribute->getValue();
            }
        }

        if (empty($prices)) {
            return false;
        }

        return min($prices);
    }
    
    
    function updateConfigurableProduct($skuconfigurable, $skusSimpleArray) {
        /**
         * Preparo i campi per il prodotto configurabile
         */
        
        $productConfId = Mage::getModel('catalog/product')->getIdBySku($skuconfigurable);  
        if(!$productConfId){
            throw new Exception("Prodotto configurabile non esistente" );
        }
        $productConf = Mage::getModel('catalog/product')->load($productConfId);
        
        

        $skus = $skusSimpleArray;



        $associatedProducts = Mage::getModel('catalog/product')->getCollection()
                ->addAttributeToSelect('*')
                ->addAttributeToFilter('type_id', Mage_Catalog_Model_Product_Type::TYPE_SIMPLE)
                ->addAttributeToFilter('sku', array('in' => $skus));
        
        $productAttributeOptions = $productConf->getTypeInstance(true)->getConfigurableAttributesAsArray($productConf);
        $attritutesToUseForCreateConf = array();
        foreach ($productAttributeOptions as $atConf) {
            $attritutesToUseForCreateConf[] = $atConf["attribute_code"];
        }


        $label = array();
        $configAttributeValue = array();

        $productConfData = array();

        foreach ($associatedProducts as $as) {

            /* @var $product Mage_Catalog_Model_Product */
            $as = $as->load($as->getIdBySku($as->getSku()));
            $this->__log("Product id: " . $as->getId());

            foreach ($attritutesToUseForCreateConf as $configurableAttribute) {
                $this->__log("attributeCode: " . $configurableAttribute);
                $attributeData = array();
                $label[$configurableAttribute] = $as->getAttributeText($configurableAttribute);
                $attributeData['label'] = $as->getAttributeText($configurableAttribute);
                $attributeData['attribute_id'] = $associatedProducts->getAttribute($configurableAttribute)->getAttributeId();
                $attributeData['value_index'] = $as->getData($configurableAttribute);
                $attributeData['is_percent'] = 0;
                $attributeData['pricing_value'] = 0;

                $productConfData['configurable_products_data'][$as->getId()][] = $attributeData;
                $configAttributeValue[$configurableAttribute][] = $attributeData;
            }
        }

        $i = 0;
        foreach ($attritutesToUseForCreateConf as $configurableAttribute) {
            $configurableAttributesData = array();
            $configurableAttributesData['id'] = NULL;
            $configurableAttributesData['label'] = $associatedProducts->getAttribute($configurableAttribute)->getFrontendLabel(); //$label[$configurableAttribute];
            $configurableAttributesData['use_default'] = 1;
            $configurableAttributesData['position'] = NULL;
            if (isset($configAttributeValue[$configurableAttribute]))
                $configurableAttributesData['values'] = $configAttributeValue[$configurableAttribute];
            else
                $configurableAttributesData['values'] = '';
            $configurableAttributesData['attribute_id'] = $associatedProducts->getAttribute($configurableAttribute)->getAttributeId();
            $configurableAttributesData['attribute_code'] = $configurableAttribute;
            $configurableAttributesData['frontend_label'] = $associatedProducts->getAttribute($configurableAttribute)->getFrontendLabel(); //$label[$configurableAttribute];
            $configurableAttributesData['store_label'] = $associatedProducts->getAttribute($configurableAttribute)->getStoreLabel(); //$label[$configurableAttribute];
            $configurableAttributesData['html_id'] = 'configurable__attribute_' . $i++;

            //$productConfData['configurable_attributes_data'][] = $configurableAttributesData;
        }

        $productConf->addData($productConfData);

        try {
            $this->__log("----------- Aggiornamento prodotto configurabile " . $skuconfigurable . " con attributi " . implode(",", $attritutesToUseForCreateConf) . " -----------");

            $productConf->save();


        } catch (Exception $e) {
            $this->__log("Errore: " . $e->getMessage());
        }

        return $productConf;
    }    

    function insertConfigurableProduct(DataExchange_Iris_Model_Action_Product $configurable, DataExchange_Iris_Model_Mysql4_Action_Product_Attribute_Collection $attributeArray, DataExchange_Iris_Model_Mysql4_Action_Product_Collection $simpleCollection) {
        /**
         * Ottengo il minimal price per il configurabile
         */
        $minimalPrice = $this->_getMinimalPriceForConfigurable($simpleCollection);

        if (!$minimalPrice) {
            $this->__log("ATTENZIONE: price per configurable zero o null!");
        }

        /**
         * Preparo i campi per il prodotto configurabile
         */
        
        $productConf = Mage::getModel('catalog/product');      
        if(strstr($configurable->getName(),"_")){
            $name = explode("_", $configurable->getName(), 2);
            $productConf->setName($name[0]);
        }else{
            $productConf->setName($configurable->getName());
        }
        
        $websiteIdsArray = explode(',', trim($configurable->getWebsiteIds()));
        $productConf->setWebsiteIds($websiteIdsArray);
        $productConf->setPrice($minimalPrice);
        $productConf->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH);
        $productConf->setStatus(Mage::getStoreConfig('iris_product/settings/status_configurable'));
        $productConf->setTaxClassId($configurable->getTaxClass());
        $productConf->setSku($configurable->getSku());
        if ((int) Mage::getStoreConfig('iris_product/settings/mode') == DataExchange_Iris_Model_Parser_Product_Mode::ONLY_SIMPLE) {
            $productConf->setSku($configurable->getParentSku());
        }
        $productConf->setAttributeSetId($configurable->getAttributeSetId());
        $productConf->setTypeId(Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE);
        $productConf->setUseDefault(1);
        $productConf->setStockData(array(
            'is_in_stock' => Mage_CatalogInventory_Model_Stock_Status::STATUS_IN_STOCK,
            'qty' => 100
        ));
        $productConf->setCreatedAt(strtotime('now'));

        $skus = array();
        foreach ($simpleCollection as $singleAction) {
            $skus[] = $singleAction->getSku();
        }


        $associatedProducts = Mage::getModel('catalog/product')->getCollection()
                ->addAttributeToSelect('*')
                ->addAttributeToFilter('type_id', Mage_Catalog_Model_Product_Type::TYPE_SIMPLE)
                ->addAttributeToFilter('sku', array('in' => $skus));

        $attritutesToUseForCreateConf = explode(",", trim($configurable->getConfigurableAttributes()));

        $label = array();
        $configAttributeValue = array();

        $productConfData = array();

        foreach ($associatedProducts as $as) {

            /* @var $product Mage_Catalog_Model_Product */
            $as = $as->load($as->getIdBySku($as->getSku()));
            $this->__log("Product id: " . $as->getId());

            foreach ($attritutesToUseForCreateConf as $configurableAttribute) {
                $this->__log("attributeCode: " . $configurableAttribute);
                $attributeData = array();
                $label[$configurableAttribute] = $as->getAttributeText($configurableAttribute);
                $attributeData['label'] = $as->getAttributeText($configurableAttribute);
                $attributeData['attribute_id'] = $associatedProducts->getAttribute($configurableAttribute)->getAttributeId();
                $attributeData['value_index'] = $as->getData($configurableAttribute);
                $attributeData['is_percent'] = 0;
                $attributeData['pricing_value'] = 0;

                $productConfData['configurable_products_data'][$as->getId()][] = $attributeData;
                $configAttributeValue[$configurableAttribute][] = $attributeData;
            }
        }

        $i = 0;
        foreach ($attritutesToUseForCreateConf as $configurableAttribute) {
            $configurableAttributesData = array();
            $configurableAttributesData['id'] = NULL;
            $configurableAttributesData['label'] = $associatedProducts->getAttribute($configurableAttribute)->getFrontendLabel(); //$label[$configurableAttribute];
            $configurableAttributesData['use_default'] = 1;
            $configurableAttributesData['position'] = NULL;
            if (isset($configAttributeValue[$configurableAttribute]))
                $configurableAttributesData['values'] = $configAttributeValue[$configurableAttribute];
            else
                $configurableAttributesData['values'] = '';
            $configurableAttributesData['attribute_id'] = $associatedProducts->getAttribute($configurableAttribute)->getAttributeId();
            $configurableAttributesData['attribute_code'] = $configurableAttribute;
            $configurableAttributesData['frontend_label'] = $associatedProducts->getAttribute($configurableAttribute)->getFrontendLabel(); //$label[$configurableAttribute];
            $configurableAttributesData['store_label'] = $associatedProducts->getAttribute($configurableAttribute)->getStoreLabel(); //$label[$configurableAttribute];
            $configurableAttributesData['html_id'] = 'configurable__attribute_' . $i++;

            $productConfData['configurable_attributes_data'][] = $configurableAttributesData;
        }

        $productConf->addData($productConfData);

        try {
            $this->__log("----------- Salvataggio prodotto configurabile " . $configurable->getSku() . " con attributi " . $configurable->getConfigurableAttributes() . " -----------");
            $createdProduct = $productConf->save();

            if ($createdProduct->getId()) {

                //ciclo tutte le store view aggiornando attributi; parto da quella globale ovvero la store view con id 0
                $attributeFormattedArray = $this->getFormatAttributeArrays($attributeArray);

                foreach ($attributeFormattedArray as $key => $attributeCurrentArray) {
                    foreach ($attributeCurrentArray as $attribute) {
                        //aggiorno l'attributo
                        $this->updateAttribute($createdProduct->getId(), $attribute->getAttributeCode(), $attribute->getType(), $attribute->getValue(), $attribute->getStoreId());
                    }
                }
            }

            foreach ($simpleCollection as $simple)
                $simple->setHasBeenProcessed();
        } catch (Exception $e) {
            $this->__log("Errore: " . $e->getMessage());
        }

        return $createdProduct;
    }
    
    /**
     * 
     * @param type $originalProductConfigurable
     * @param type $skuSimples collection di semplici da duplicare
     * @param type $configurableAttributes ex: colore,taglia
     * @param type $suffix ex: "_sc"
     * @return type
     */
    function duplicateConfigurableProduct($originalProductConfigurable, $skuSimples, $configurableAttributes, $suffix) {
        /**
         * Ottengo il minimal price per il configurabile
         */
        $minimalPrice = 0;

        //duplico il configurabile
        
        $productConf = Mage::getModel("catalog/product");
        $newData = $originalProductConfigurable->getData();
        unset($newData["entity_id"]);
        unset($newData["stock_item"]);
        $productConf->setData($newData);
        //controllo se il prodotto esiste già:
        $checkProductId = Mage::getModel("catalog/product")->getIdBySku($originalProductConfigurable->getSku().$suffix);
        if($checkProductId){
            $this->__log("Errore: il prodotto duplicato esiste già!");
            return null;
        }
        $productConf->setSku($originalProductConfigurable->getSku().$suffix);
        $productConf->setUrlKey(Mage::getModel('catalog/product_url')->formatUrlKey($originalProductConfigurable->getUrlKey().$suffix));
        $productConf->setUseDefault(1);
        $productConf->setCreatedAt(strtotime('now'));
        $productConf->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG);
        $productConf->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED);
        $productConf->setWebsiteIds($originalProductConfigurable->getWebsiteIds());
        $productConf->setProductExpiration($originalProductConfigurable->getSku());
        $productConf->setScadenzaBreve(1);
        $productConf->setData("promotion_type","173");
        $productConf->setStockData(array(
            'is_in_stock' => Mage_CatalogInventory_Model_Stock_Status::STATUS_IN_STOCK,
            'qty' => 100
        ));        
        
        
        
        //imposto l'immagine
        $baseDir = Mage::getBaseDir('media').DS."catalog/product";
        $curImage = $originalProductConfigurable->getData("image");
        $productConf->addImageToMediaGallery($baseDir.$curImage, array('image','small_image','thumbnail'),false, false);           
        
        
        $associatedProducts = $skuSimples;

        $attritutesToUseForCreateConf = explode(",", trim($configurableAttributes));

        $label = array();
        $configAttributeValue = array();

        $productConfData = array();

        foreach ($associatedProducts as $as) {

            /* @var $product Mage_Catalog_Model_Product */
            $as = $as->load($as->getIdBySku($as->getSku()));
            $this->__log("Product id: " . $as->getId());

            foreach ($attritutesToUseForCreateConf as $configurableAttribute) {
                $this->__log("attributeCode: " . $configurableAttribute);
                $attributeData = array();
                $label[$configurableAttribute] = $as->getAttributeText($configurableAttribute);
                $attributeData['label'] = $as->getAttributeText($configurableAttribute);
                $attributeData['attribute_id'] = $associatedProducts->getAttribute($configurableAttribute)->getAttributeId();
                $attributeData['value_index'] = $as->getData($configurableAttribute);
                $attributeData['is_percent'] = 0;
                $attributeData['pricing_value'] = 0;

                $productConfData['configurable_products_data'][$as->getId()][] = $attributeData;
                $configAttributeValue[$configurableAttribute][] = $attributeData;
            }
        }

        $i = 0;
        foreach ($attritutesToUseForCreateConf as $configurableAttribute) {
            $configurableAttributesData = array();
            $configurableAttributesData['id'] = NULL;
            $configurableAttributesData['label'] = $associatedProducts->getAttribute($configurableAttribute)->getFrontendLabel(); //$label[$configurableAttribute];
            $configurableAttributesData['use_default'] = 1;
            $configurableAttributesData['position'] = NULL;
            if (isset($configAttributeValue[$configurableAttribute]))
                $configurableAttributesData['values'] = $configAttributeValue[$configurableAttribute];
            else
                $configurableAttributesData['values'] = '';
            $configurableAttributesData['attribute_id'] = $associatedProducts->getAttribute($configurableAttribute)->getAttributeId();
            $configurableAttributesData['attribute_code'] = $configurableAttribute;
            $configurableAttributesData['frontend_label'] = $associatedProducts->getAttribute($configurableAttribute)->getFrontendLabel(); //$label[$configurableAttribute];
            $configurableAttributesData['store_label'] = $associatedProducts->getAttribute($configurableAttribute)->getStoreLabel(); //$label[$configurableAttribute];
            $configurableAttributesData['html_id'] = 'configurable__attribute_' . $i++;

            $productConfData['configurable_attributes_data'][] = $configurableAttributesData;
        }

        $productConf->addData($productConfData);

        try {
            $this->__log("----------- Duplicazione prodotto configurabile " . $originalProductConfigurable->getSku() . " con attributi " . $configurableAttributes . " -----------");
            $createdProduct = $productConf->save();
            
            //setto il prodotto nuovo nel suo gemello non in scadenza
            $this->updateAttributeNoChecks($originalProductConfigurable->getId(), "product_expiration", $createdProduct->getSku(), 0);
            
            //aggiorno gli attributi che possono esseere tradotti:
            $this->__log("Copia dei campi di lingua");
            $engStoreId1 = 3;
            $engProduct = Mage::getModel('catalog/product')->setStoreId($engStoreId1)->load($originalProductConfigurable->getId());            
            Mage::getSingleton('catalog/product_action')->updateAttributes(array($createdProduct->getId()), 
                    array(
                        "name" => $engProduct->getName(),
                        "description" => $engProduct->getData("description"),
                        "short_description" => $engProduct->getData("short_description"),
                        "informazioni_nutrizionali" => $engProduct->getData("informazioni_nutrizionali"),
                        "dosaggio_consigliato" => $engProduct->getData("dosaggio_consigliato"),
                        "avvertenze" => $engProduct->getData("avvertenze"),
                        "caratteristiche" => $engProduct->getData("caratteristiche"),                        
                        "composizione" => $engProduct->getData("composizione"),
                        "modo_uso" => $engProduct->getData("modo_uso")                        
                    ), 
            $engStoreId1);
            $engStoreId2 = 4;
            $engProduct = Mage::getModel('catalog/product')->setStoreId($engStoreId2)->load($originalProductConfigurable->getId());            
            Mage::getSingleton('catalog/product_action')->updateAttributes(array($createdProduct->getId()), 
                    array(
                        "name" => $engProduct->getName(),
                        "description" => $engProduct->getData("description"),
                        "short_description" => $engProduct->getData("short_description"),
                        "informazioni_nutrizionali" => $engProduct->getData("informazioni_nutrizionali"),
                        "dosaggio_consigliato" => $engProduct->getData("dosaggio_consigliato"),
                        "avvertenze" => $engProduct->getData("avvertenze"),
                        "caratteristiche" => $engProduct->getData("caratteristiche"),                        
                        "composizione" => $engProduct->getData("composizione"),
                        "modo_uso" => $engProduct->getData("modo_uso")                        
                    ), 
            $engStoreId2);            
            
        } catch (Exception $e) {
            $this->__log("Errore: " . $e->getMessage());
        }

        return $createdProduct;
    }    

    /**
     * Funzione che controlla la presenza dei super attributi di un prodotto configurabile, e li recupera
     * @param <type> $conf_product_sku
     * @param <type> $attribute_id
     * @return <type>
     */
    public function getSuperAttributeId($conf_product_sku, $attribute_id) {
        $conf_product = Mage::getModel('catalog/product')->loadByAttribute('sku', $conf_product_sku);
        if ($conf_product != NULL) {
            $conf_attr_data = $conf_product->getTypeInstance(true)->getConfigurableAttributesAsArray($conf_product);
            if ($conf_attr_data != NULL) {
                //Mage::log("configurable_attributes_data: " . $conf_attr_data);
                foreach ($conf_attr_data as $attr_data) {
                    if ($attr_data["attribute_id"] == $attribute_id) {
                        //Mage::log("ID ESISTENTE: " . $attr_data["id"]);
                        return $attr_data["id"];
                    }
                }
            }
        }
        return NULL;
    }

}