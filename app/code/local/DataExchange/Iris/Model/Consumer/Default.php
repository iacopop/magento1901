<?php

class DataExchange_Iris_Model_Consumer_Default extends DataExchange_Iris_Model_Consumer_Abstract {

    public function consumeRows($indexes_manual_mode = false) {
        if($indexes_manual_mode){
            Mage::helper("iris/log")->log("Imposto gli indici in manual mode!");
            Mage::helper("iris/indexer")->setIndexesToManualMode();
        }
        //prendo tutte le righe ancora da processare ordinate in modo crescente
        $collection = Mage::getModel("iris/action_product")->getCollection()
                ->addFieldToFilter('status', 'to_be_processed')
                ->setOrder("id", Varien_Data_Collection::SORT_ORDER_ASC);

        //Consumo le righe. E' importante l'ordine perchè è necessario consumare in ordine per il quale inserisco
        foreach ($collection as $action) {
            if ($action->getActionType() == DataExchange_Iris_Model_Dal_Product_Default::ACTION_TYPE_INSERT) {
                if ($action->getProductType() == "simple") {
                    Mage::helper("iris/log")->log("azione insert simple con ID: " . $action->getId());
                    $this->consumeSimpleProductRow($action->getId());
                } else if ($action->getProductType() == "configurable") {
                    Mage::helper("iris/log")->log("azione insert configurabile con ID: " . $action->getId());
                    $this->consumeConfigurableProductRow($action->getId());
                }
            } else if ($action->getActionType() == DataExchange_Iris_Model_Dal_Product_Default::ACTION_TYPE_UPDATE) {
                Mage::helper("iris/log")->log("update: azione non implementata");
            } else {
                Mage::helper("iris/log")->log("altro: azione non implementata");
            }
        }

        /**
         * Modo consumazione: se semplici e configurabili ( ordinato per id di azione) non fa nulla
         * da qui in avanti.
         * 
         * Se solo solo semplici fa query e chiama consumeconfigurable
         */
        if ((int) Mage::getStoreConfig('iris_product/settings/mode') == DataExchange_Iris_Model_Parser_Product_Mode::ONLY_SIMPLE) {
            $configurableCollection = Mage::getModel('iris/action_product')->getCollection()
                    ->addFieldToFilter('status', 'processing_for_configurable');

            $configurableCollection->getSelect()
                    ->group(array('parent_sku'));

            foreach ($configurableCollection as $actionModel){
                $this->consumeConfigurableProductRow($actionModel->getId());
            }
        }
        
        if($indexes_manual_mode){
            Mage::helper("iris/log")->log("Imposto gli indici in auto mode!");
            Mage::helper("iris/indexer")->setIndexesToAutoMode();
            Mage::helper("iris/indexer")->reindex();
        }        
    }

    public function consumeSimpleProductRow($rowId) {
        //prendo il rowId e formatto i valori da passare all'helper che crea/aggiorna i prodotti
        $actionModel = Mage::getModel("iris/action_product")->load($rowId);
        if ($actionModel->getId()) {
            //controllo il tipo di azione
            switch ($actionModel->getActionType()) {
                case DataExchange_Iris_Model_Dal_Product_Default::ACTION_TYPE_INSERT:
                    Mage::helper("iris/product")->insertSingleProduct($actionModel, $actionModel->getAttributesCollection());

                    if (!$actionModel->getParentSku())
                        $actionModel->setHasBeenProcessed();
                    else
                        $actionModel->setNeedToBeProcessedForConfigurable();

                    break;
                case DataExchange_Iris_Model_Dal_Product_Default::ACTION_TYPE_UPDATE:
                    Mage::helper("iris/log")->log("update: azione non implementata");
                    break;
                default:
                    break;
            }
        }
    }

    public function consumeConfigurableProductRow($rowId) {
        //prendo il rowId e formatto i valori da passare all'helper che crea/aggiorna i prodotti
        $actionModel = Mage::getModel("iris/action_product")->load($rowId);
        if ($actionModel->getId()) {
            //controllo il tipo di azione
            switch ($actionModel->getActionType()) {
                case DataExchange_Iris_Model_Dal_Product_Default::ACTION_TYPE_INSERT:
                    //prendo tutti i prodotti semplici figli del configurabile
                    $simpleActionCollection = Mage::getModel("iris/action_product")->getCollection()
                            ->addFieldToFilter('status', 'processing_for_configurable');

                    if ((int) Mage::getStoreConfig('iris_product/settings/mode') == DataExchange_Iris_Model_Parser_Product_Mode::ONLY_SIMPLE) {
                        $simpleActionCollection->addFieldToFilter('parent_sku', $actionModel->getParentSku());
                    }

                    if ((int) Mage::getStoreConfig('iris_product/settings/mode') == DataExchange_Iris_Model_Parser_Product_Mode::CONFIGURABLE_AND_SIMPLE) {
                        $simpleActionCollection->addFieldToFilter('parent_sku', $actionModel->getSku());
                    }

                    Mage::helper("iris/product")->insertConfigurableProduct($actionModel, $actionModel->getAttributesCollection(), $simpleActionCollection);
                    $actionModel->setHasBeenProcessed();

                    foreach ($simpleActionCollection as $actionModel)
                        $actionModel->setHasBeenProcessed();

                    break;
                case DataExchange_Iris_Model_Dal_Product_Default::ACTION_TYPE_UPDATE:
                    Mage::helper("iris/log")->log("azione non implementata");
                    break;
                default:
                    break;
            }
        }
    }

}

?>
