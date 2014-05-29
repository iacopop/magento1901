<?php

class DataExchange_Iris_Helper_Indexer extends Mage_Core_Helper_Abstract {

    public function setIndexesToManualMode() {

        $changedIndexes = array();

        $collection = Mage::getSingleton('index/indexer')->getProcessesCollection();

        foreach ($collection as $process) {
            if ($process->getMode() == Mage_Index_Model_Process::MODE_REAL_TIME) {
                $process->setMode(Mage_Index_Model_Process::MODE_MANUAL)->save();
                Mage::helper("iris/log")->log("Index process " . $process->getName() . " (" . $process->getIndexerCode() . ") set to manual mode");
                $changedIndexes[] = $process->getIndexerCode();
            }
        }

        return $changedIndexes;
    }

    public function setIndexesToAutoMode() {

        foreach (Mage::getSingleton('index/indexer')->getProcessesCollection() as $code) {
            $process = Mage::getSingleton('index/indexer')->getProcessByCode($code->getIndexerCode());
            $process->setMode(Mage_Index_Model_Process::MODE_REAL_TIME)->save();
            Mage::helper("iris/log")->log("Index process " . $process->getName() . " (" . $process->getIndexerCode() . ") set to auto mode");
        }
    }

    public function reindex() {
        foreach (Mage::getSingleton('index/indexer')->getProcessesCollection() as $code) {
            $process = Mage::getSingleton('index/indexer')->getProcessByCode($code->getIndexerCode());
            $process->reindexEverything();
            Mage::helper("iris/log")->log("Index process " . $process->getName() . " (" . $process->getIndexerCode() . ") reindexed");
        }
    }

    public function reindexSingleProductAfterSave($productId) {
        $product = Mage::getModel("catalog/product")->load($productId);

        $event = Mage::getSingleton('index/indexer')->logEvent(
                $product, $product->getResource()->getType(), Mage_Index_Model_Event::TYPE_SAVE, true
        );

        foreach (Mage::getSingleton('index/indexer')->getProcessesCollection() as $code) {
            Mage::getSingleton('index/indexer')
                    ->getProcessByCode($code->getIndexerCode()) // Adjust the indexer process code as needed
                    ->setMode(Mage_Index_Model_Process::MODE_REAL_TIME)
                    ->processEvent($event);
        }
    }

}

?>
