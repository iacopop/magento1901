<?php

/**
 * Riscrittura: aggiunto parametro $reindex per eliminare il collo di bottiglia 
 * per cui facendo girare IRIS con i reindex disabilitati, si riempiva la tabella
 * index_event
 * 
 * NOTA: Quando si lancia un updateAttributes con reindex a FALSE, in caso di 
 * aggiornamento dei prezzi, sarà necessario fare un reindex
 */
class DataExchange_Iris_Model_Product_Action extends Mage_Catalog_Model_Product_Action {

    
    
    public function updateAttributes($productIds, $attrData, $storeId)
    {
        
        //ottengo la proprietà
        $enable_index = true;
        
        $status_event = Mage::getStoreConfig('iris_product/settings/status_event');
        if($status_event === "1"){
            $enable_index = false;
        }
        
        if($enable_index){
            Mage::dispatchEvent('catalog_product_attribute_update_before', array(
                'attributes_data' => &$attrData,
                'product_ids'   => &$productIds,
                'store_id'      => &$storeId
            ));
        }

        $this->_getResource()->updateAttributes($productIds, $attrData, $storeId);
        
        
        if($enable_index){
            $this->setData(array(
                'product_ids'       => array_unique($productIds),
                'attributes_data'   => $attrData,
                'store_id'          => $storeId
            ));

            // register mass action indexer event
            Mage::getSingleton('index/indexer')->processEntityAction(
                $this, Mage_Catalog_Model_Product::ENTITY, Mage_Index_Model_Event::TYPE_MASS_ACTION
            );
        }
        return $this;
    }    

}
