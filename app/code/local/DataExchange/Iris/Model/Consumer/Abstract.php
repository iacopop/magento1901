<?php

abstract class DataExchange_Iris_Model_Consumer_Abstract implements DataExchange_Iris_Model_Consumer_Interface{
    abstract function consumeRows();
    
    abstract function consumeSimpleProductRow($rowId);
}
?>
