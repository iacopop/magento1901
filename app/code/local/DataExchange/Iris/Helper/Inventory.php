<?php

class DataExchange_Iris_Helper_Inventory {

    function __log($message) {
        Mage::helper("iris/log")->log($message);
    }

    public function updateProductInventory($productId, $qty) {
        if (!$productId) {
            return;
        }
        
        $stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct($productId);

        if ($stockItem->getId()) {
            if ((int) $qty > 0) {
                $stockItem->setIsInStock(Mage_CatalogInventory_Model_Stock_Status::STATUS_IN_STOCK);
            } else {
                $stockItem->setIsInStock(Mage_CatalogInventory_Model_Stock_Status::STATUS_OUT_OF_STOCK);
            }

            try {
                if ($stockItem->getId()) {
                    $stockItem->setQty((int) $qty);
                    $stockItem->save();
                    $this->__log('Stock updated for product ' . $productId . " with status: " . $stockItem->getIsInStock() . " and qty: " . $stockItem->getQty());
                }
            } catch (Exception $e) {
                $this->__log('Unable to update stock for product: ' . $productId);
            }
        }
        unset($stockItem);
    }

}

?>
