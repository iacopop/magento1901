<?php

interface DataExchange_Iris_Model_Consumer_Interface {
    public function consumeRows();
    
    /**
     * esegue una unica riga della tabella dei lavori (simula la sincronia)
     */
    public function consumeSimpleProductRow($rowId);
}
?>
