<?php

class DataExchange_Iris_Model_Consumer_Order_Csv_Default extends DataExchange_Iris_Model_Consumer_Order_Default {

    private $exportDirectory;

    function __construct($exportDirectory) {
        $this->exportDirectory = $exportDirectory;
    }
    
    public function consumeRows() {
        //prendo tutte le righe ancora da processare ordinate in modo crescente
        $collection = Mage::getModel("iris/action_order")->getCollection()
                ->addFieldToFilter('status', DataExchange_Iris_Model_Dal_Order_Default::ACTION_STATUS_TO_BE_PROCESSED)
                ->setOrder("id", Varien_Data_Collection::SORT_ORDER_ASC);

        //Consumo le righe ordine per l'export
        $exportOrders = array();
        foreach ($collection as $action) {
            if ($action->getActionType() == DataExchange_Iris_Model_Dal_Order_Default::ACTION_TYPE_INSERT) {
                $exportOrders[] = $this->consumeOrder($action->getId());
                $action->setHasBeenProcessed();
            } else {
                Mage::helper("iris/log")->log("Azione per ordine non implementata");
            }
        }   
        
        $dateString = date("Y_m_d_H_i_s");
        $fp = fopen($this->exportDirectory.DS."orders_export_".$dateString.".csv", 'w');

        foreach ($exportOrders as $order) {            
            foreach ($order as $orderLine) {            
                fputcsv($fp, $orderLine,",",'"');
            }
        }

        fclose($fp);        
    }    

    public function consumeOrder($action_order_id) {
        $actionOrder = Mage::getModel("iris/action_order")->load($action_order_id);

        $exportOrder = array();
        $actionOrderArray = $actionOrder->getData();

        foreach ($actionOrder->getRowsCollection() as $row) {
            
            $exportOrder[] = array_merge($actionOrderArray, $row->getData());
        }

        return $exportOrder;
    }

}

?>
