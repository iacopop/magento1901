<?php

declare(ticks=1); 

class DataExchange_Iris_Model_Consumer_MultithreadConsumer extends DataExchange_Iris_Model_Consumer_Abstract {

    public $maxProcesses = 4; 
    protected $jobsStarted = 0; 
    protected $currentJobs = array(); 
    protected $signalQueue=array();   
    protected $parentPID; 
   
    public function __construct(){ 
        Mage::helper("iris/log")->log("Multithread worker activated!"); 
        $this->parentPID = getmypid(); 
        pcntl_signal(SIGCHLD, array($this, "childSignalHandler")); 
    } 
    
    /** 
    * Run the Daemon 
    */ 
    public function run(){ 
        Mage::helper("iris/log")->log("Multithread running....");; 
        Mage::helper("iris/log")->log("Multithread start time: ".date("Y-m-d H:i:s"));
        
        Mage::helper("iris/indexer")->setIndexesToManualMode();
        //prendo tutte le righe ancora da processare ordinate in modo crescente
        $collection = Mage::getModel("iris/action_product")->getCollection()
                ->addFieldToFilter('status', 'to_be_processed')
                ->setOrder("id", Varien_Data_Collection::SORT_ORDER_ASC);

        //Consumo le righe. E' importante l'ordine perchè è necessario consumare in ordine per il quale inserisco
        foreach ($collection as $action) {
            
            $jobID = $action->getId();
            
            while(count($this->currentJobs) >= $this->maxProcesses){ 
               Mage::helper("iris/log")->log("Maximum children allowed, waiting..."); 
               sleep(1); 
            } 

            $launched = $this->launchJob($jobID, $action, $action->getProductType());             
                        
        }
        
        //Wait for child processes to finish before exiting here 
        while(count($this->currentJobs)){ 
            Mage::helper("iris/log")->log("Waiting for current jobs to finish... "); 
            sleep(1); 
        } 
        Mage::helper("iris/indexer")->setIndexesToAutoMode();
        Mage::helper("iris/log")->log("Multithread finish time: ".date("Y-m-d H:i:s"));        
     
    } 
   
    /** 
    * Launch a job from the job queue 
    */ 
    private function launchJob($jobID, $action, $type){ 
        $pid = pcntl_fork(); 
        if($pid == -1){ 
            //Problem launching the job 
            error_log('Could not launch new job, exiting'); 
            return false; 
        } 
        else if ($pid){ 
            // Parent process 
            // Sometimes you can receive a signal to the childSignalHandler function before this code executes if 
            // the child script executes quickly enough! 
            // 
            Mage::app();
            $this->currentJobs[$pid] = $jobID; 
            
            // In the event that a signal for this pid was caught before we get here, it will be in our signalQueue array 
            // So let's go ahead and process it now as if we'd just received the signal 
            if(isset($this->signalQueue[$pid])){ 
                Mage::helper("iris/log")->log("found $pid in the signal queue, processing it now"); 
                $this->childSignalHandler(SIGCHLD, $pid, $this->signalQueue[$pid]); 
                unset($this->signalQueue[$pid]); 
            } 
        } 
        else{ 
            //Forked child, do your deeds.... 
            $exitStatus = 0; //Error code if you need to or whatever 

            if($type == "simple"){
                //$consumer = new DataExchange_Iris_Model_Consumer_Default();
                //$consumer->consumeSimpleProductRow($jobID); 
                pcntl_exec("/usr/bin/php", array("../app/code/local/DataExchange/Iris/Helper/Script/consume_single_action.php", "--action=insert" ,"--id=$jobID" ,"--type=simple"));

                

            }else if($type = "configurable"){
                $consumer = new DataExchange_Iris_Model_Consumer_Default();
                //$consumer->consumeConfigurableProductRow($jobID);
            }
            
            Mage::helper("iris/log")->log("Doing something fun in pid ".getmypid()); 
            exit($exitStatus); 
        } 
        return true; 
    } 
   
    private function childSignalHandler($signo, $pid=null, $status=null){ 
       
        //If no pid is provided, that means we're getting the signal from the system.  Let's figure out 
        //which child process ended 
        if(!$pid){ 
            $pid = pcntl_waitpid(-1, $status, WNOHANG); 
        } 
       
        //Make sure we get all of the exited children 
        while($pid > 0){ 
            if($pid && isset($this->currentJobs[$pid])){ 
                $exitCode = pcntl_wexitstatus($status); 
                if($exitCode != 0){ 
                    Mage::helper("iris/log")->log("$pid exited with status ".$exitCode); 
                } 
                unset($this->currentJobs[$pid]); 
            } 
            else if($pid){ 
                //Oh no, our job has finished before this parent process could even note that it had been launched! 
                //Let's make note of it and handle it when the parent process is ready for it 
                Mage::helper("iris/log")->log("..... Adding $pid to the signal queue ....."); 
                $this->signalQueue[$pid] = $status; 
            } 
            $pid = pcntl_waitpid(-1, $status, WNOHANG); 
        } 
        return true; 
    }     
    
    public function consumeRows() {
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

            foreach ($configurableCollection as $actionModel)
                $this->consumeConfigurableProductRow($actionModel->getId());
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

    private function consumeConfigurableProductRow($rowId) {
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
