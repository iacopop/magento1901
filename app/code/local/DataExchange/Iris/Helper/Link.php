<?php

class DataExchange_Iris_Helper_Link extends Mage_Core_Helper_Abstract {

    public function generateCrosssell($limit = 4) {
        //prendo tutti i prodotti enabled e visibili
        $collection = Mage::getModel("catalog/product")->getCollection()
                ->addAttributeToFilter("visibility", Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->addAttributeToFilter("status", Mage_Catalog_Model_Product_Status::STATUS_ENABLED);

        $arrayCorrelati = array();

        /*

          Questo array contiene l'informazione di ogni prodotto e degli altri sku che vengono acquistati con esso
          L'array seguente dice che assieme al prodotto SKU sono stati comprati product_id1 una volta, product_id2 3 volte, product_id3 1 volta
          Andremo ad ordinare l'array per il numero di volte e presenteremo i prodotti nei correlati



          $arrayCorrelati["product_id"] = array(
          "product_id1" => 1,
          "product_id2" => 3,
          "product_id3" => 1
          );


         */

        //per ognuno di questi controllo gli ordini nei quali sono stati acquistati
        foreach ($collection as $product) {

            $arrayCorrelati[$product->getId()] = array();
            
            $cats = $product->getCategoryIds();
            if ($cats) {
                $arrayCorrelati[$product->getId()] = Mage::helper("iris/link")->getRandomProductForCategory($cats[0], $limit);
            } else {
                unset($arrayCorrelati[$product->getId()]);
            }           
        }
        
        return $arrayCorrelati;
    }    
    
    public function generateRelated($limit = 4) {
        //prendo tutti i prodotti enabled e visibili
        $collection = Mage::getModel("catalog/product")->getCollection()
                ->addAttributeToFilter("visibility", Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->addAttributeToFilter("status", Mage_Catalog_Model_Product_Status::STATUS_ENABLED);



        $time = time();
        $to = date('Y-m-d H:i:s', $time);
        $lastTime = $time - 864000; // 60*60*24*100
        $from = date('Y-m-d H:i:s', $lastTime);
        Mage::log("Start correlati automatici");


        $arrayCorrelati = array();

        /*

          Questo array contiene l'informazione di ogni prodotto e degli altri sku che vengono acquistati con esso
          L'array seguente dice che assieme al prodotto SKU sono stati comprati product_id1 una volta, product_id2 3 volte, product_id3 1 volta
          Andremo ad ordinare l'array per il numero di volte e presenteremo i prodotti nei correlati



          $arrayCorrelati["product_id"] = array(
          "product_id1" => 1,
          "product_id2" => 3,
          "product_id3" => 1
          );


         */

        //per ognuno di questi controllo gli ordini nei quali sono stati acquistati
        foreach ($collection as $product) {

            $arrayCorrelati[$product->getId()] = array();
            
            $cats = $product->getCategoryIds();
            if ($cats) {
                $arrayCorrelati[$product->getId()] = Mage::helper("iris/link")->getRandomProductForCategory($cats[0], $limit);
            } else {
                unset($arrayCorrelati[$product->getId()]);
            }           
        }
        
        return $arrayCorrelati;
    }
    
    /**
     * 
     * @param type $limit = numero di correlati per prodotto
     * @param type $checkOrder = prende i correlati dai prodotti
     * @return type
     */
    public function generateUpsell($limit = 4,$checkOrder=false) {
        $vitaminCompanyBrandId = 655;
        //prendo tutti i prodotti enabled e visibili
        $collection = Mage::getModel("catalog/product")->getCollection()
                ->addAttributeToFilter("visibility", Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->addAttributeToFilter("status", Mage_Catalog_Model_Product_Status::STATUS_ENABLED);



        $time = time();
        $to = date('Y-m-d H:i:s', $time);
        $lastTime = $time - 864000; // 60*60*24*100
        $from = date('Y-m-d H:i:s', $lastTime);
        Mage::log("Start correlati automatici");


        $arrayCorrelati = array();

        /*

          Questo array contiene l'informazione di ogni prodotto e degli altri sku che vengono acquistati con esso
          L'array seguente dice che assieme al prodotto SKU sono stati comprati product_id1 una volta, product_id2 3 volte, product_id3 1 volta
          Andremo ad ordinare l'array per il numero di volte e presenteremo i prodotti nei correlati



          $arrayCorrelati["product_id"] = array(
          "product_id1" => 1,
          "product_id2" => 3,
          "product_id3" => 1
          );


         */

        //per ognuno di questi controllo gli ordini nei quali sono stati acquistati
        foreach ($collection as $product) {

            $arrayCorrelati[$product->getId()] = array();
            
            if($checkOrder){
                $order_items = Mage::getResourceModel('sales/order_item_collection')
                    ->addAttributeToSelect('order_id')
                    ->addAttributeToSelect('product_id')
                    ->addAttributeToFilter('created_at', array('from' => $from, 'to' => $to))
                    ->addAttributeToFilter('product_id', $product->getId())
                    ->load();
            }else{
                $order_items = new Varien_Data_Collection();
            }

            
            //if ($order_items->count() == 0) {
            

            if ($order_items->count() == 0) {
                $cats = $product->getCategoryIds();
                if ($cats) {
                    $topProducts = Mage::helper("iris/link")->getRandomProductForCategoryWithSpecificBrand($cats[0], $limit,$vitaminCompanyBrandId);
                    if(count($topProducts) >= $limit){
                        $arrayCorrelati[$product->getId()] = $topProducts;
                    }else{
                        $productsMissingNumber = $limit - count($topProducts);
 
                        
                        $missingProducts = Mage::helper("iris/link")->getRandomProductForCategory($cats[0], $productsMissingNumber);
                        //aggiungere i prodotti TOP e quelli MISSING (altri marchi) all'array Correlati
                        if(!empty($topProducts)){
                            $arrayCorrelati[$product->getId()] = $topProducts;
                        }
                        
                        if(!is_array($arrayCorrelati[$product->getId()])){
                            $arrayCorrelati[$product->getId()] = array();
                        }

                        foreach ($missingProducts as $key => $value) {
                            $arrayCorrelati[$product->getId()][$key] = $value;
                        }
                    }
                } else {
                    unset($arrayCorrelati[$product->getId()]);
                }
                continue;
            } else {
                Mage::log("Start product " . $product->getSku());
                //Mage::log($order_items->getData());
                //ciclo gli ordini
                foreach ($order_items as $it) {

                    $order = Mage::getModel("sales/order")->load($it->getData("order_id"));
                    //ottengo la lista di items di ogni ordine
                    foreach ($order->getAllItems() as $orderItem) {
                        if ($orderItem->getProductId() != $product->getId() && $orderItem->getParentItemId() == null) {
                            //aggiungo l'item all'array
                            if (array_key_exists($orderItem->getProductId(), $arrayCorrelati[$product->getId()])) {
                                $curValue = $arrayCorrelati[$product->getId()][$orderItem->getProductId()];
                                $arrayCorrelati[$product->getId()][$orderItem->getProductId()] = $curValue + 1;
                            } else {
                                $arrayCorrelati[$product->getId()][$orderItem->getProductId()] = 1;
                            }
                        }
                    }
                }
                
                //ordino e rimuovo quelli sopra limit
                arsort($arrayCorrelati[$product->getId()]);                
                $arrayCorrelati[$product->getId()] = array_slice($arrayCorrelati[$product->getId()],0,$limit,true);                                
                
            }
        }
        
        return $arrayCorrelati;
    }    

    public function resetProductLinks() {
        $resource = Mage :: getSingleton('core/resource');
        $write = $resource->getConnection('core_write');
        $write->query("delete from catalog_product_link_attribute_int");
        $write->query("delete from catalog_product_link");
    }

    public function getRandomProductForCategory($categoryId, $limit = 4) {
        if ($categoryId) {
            $category = Mage::getModel("catalog/category")->load($categoryId);
            $productArray = array();
            $products = $category->getProductCollection();
            $products->addAttributeToFilter(
                    array(
                array('attribute' => 'prodotto_nascosto', 'null' => true),
                array('attribute' => 'prodotto_nascosto', 'neq' => 1),
                    ), '', 'left'
            );
            $products->addAttributeToSelect('sku');
            $products->getSelect()->order('RAND()');
            $products->getSelect()->limit($limit);
            foreach ($products as $prod) {
                $productArray[$prod->getId()] = 1;
            }
            return $productArray;
        } else {
            return null;
        }
    }
    
    public function getRandomProductForCategoryWithSpecificBrand($categoryId, $limit = 4,$brandId) {
        if ($categoryId) {
            $category = Mage::getModel("catalog/category")->load($categoryId);
            $productArray = array();
            $products = $category->getProductCollection();
            $products->addAttributeToFilter("aw_shopbybrand_brand",$brandId);
            $products->addAttributeToFilter(
                    array(
                array('attribute' => 'prodotto_nascosto', 'null' => true),
                array('attribute' => 'prodotto_nascosto', 'neq' => 1),
                    ), '', 'left'
            );
            $products->addAttributeToSelect('sku');
            $products->getSelect()->order('RAND()');
            $products->getSelect()->limit($limit);
            foreach ($products as $prod) {
                $productArray[$prod->getId()] = 1;
            }
            return $productArray;
        } else {
            return null;
        }
    }    

    public function insertRelated($productId, $linkProductId) {
        $ordinal = 0;
        $resource = Mage :: getSingleton('core/resource');
        $write = $resource->getConnection('core_write');
        $read = $resource->getConnection('core_read');
        $linkTable = $resource->getTableName('catalog/product_link');
        $write->query("INSERT into $linkTable SET
                            product_id='" . $productId . "',
                            linked_product_id='" . $linkProductId . "',
                            link_type_id='" . Mage_Catalog_Model_Product_Link::LINK_TYPE_RELATED . "'
        ");

        $result = $read->query("SELECT * FROM $linkTable WHERE
                product_id='" . $productId . "' and
                linked_product_id='" . $linkProductId . "' and
                link_type_id='" . Mage_Catalog_Model_Product_Link::LINK_TYPE_RELATED . "'");
        $link = $result->fetch(PDO::FETCH_ASSOC);

        $write->query("INSERT into catalog_product_link_attribute_int SET
                product_link_attribute_id = 4,
                link_id  = " . $link['link_id'] . ",  
                value = $ordinal");
    }

    public function insertCrosssell($productId, $linkProductId) {
        $ordinal = 0;
        $resource = Mage :: getSingleton('core/resource');
        $write = $resource->getConnection('core_write');
        $read = $resource->getConnection('core_read');
        $linkTable = $resource->getTableName('catalog/product_link');
        $write->query("INSERT into $linkTable SET
                            product_id='" . $productId . "',
                            linked_product_id='" . $linkProductId . "',
                            link_type_id='" . Mage_Catalog_Model_Product_Link::LINK_TYPE_CROSSSELL . "'
        ");
        $result = $read->query("SELECT * FROM $linkTable WHERE
                product_id='" . $productId . "' and
                linked_product_id='" . $linkProductId . "' and
                link_type_id='" . Mage_Catalog_Model_Product_Link::LINK_TYPE_CROSSSELL . "'");
        $link = $result->fetch(PDO::FETCH_ASSOC);

        $write->query("INSERT into catalog_product_link_attribute_int SET
                product_link_attribute_id = 4,
                link_id  = " . $link['link_id'] . ",  
                value = $ordinal");
    }

    public function insertUpsell($productId, $linkProductId) {
        $ordinal = 0;
        $resource = Mage :: getSingleton('core/resource');
        $write = $resource->getConnection('core_write');
        $read = $resource->getConnection('core_read');
        $linkTable = $resource->getTableName('catalog/product_link');
        $write->query("INSERT into $linkTable SET
                    product_id='" . $productId . "',
                    linked_product_id='" . $linkProductId . "',
                    link_type_id='" . Mage_Catalog_Model_Product_Link::LINK_TYPE_UPSELL . "'
        ");

        $result = $read->query("SELECT * FROM $linkTable WHERE
                product_id='" . $productId . "' and
                linked_product_id='" . $linkProductId . "' and
                link_type_id='" . Mage_Catalog_Model_Product_Link::LINK_TYPE_UPSELL . "'");
        $link = $result->fetch(PDO::FETCH_ASSOC);

        $write->query("INSERT into catalog_product_link_attribute_int SET
                product_link_attribute_id = 4,
                link_id  = " . $link['link_id'] . ",  
                value = $ordinal");
    }

}

?>
