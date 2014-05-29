<?php

class DataExchange_Iris_Model_Parser_Inventory_Options {

    public function toOptionArray() {


        $moduleDir = Mage::getModuleDir('Model', 'DataExchange_Iris');

        $inventoryParserFolder = $moduleDir . DS . 'Model' . DS . 'Parser' . DS . 'Inventory' . DS;

        $parsers = scandir($inventoryParserFolder);

        $options = array();
        foreach ($parsers as $parser) {
            if (is_file($inventoryParserFolder . $parser) || $parser == '.' || $parser == '..')
                continue;

            if (file_exists($inventoryParserFolder . $parser . DS . 'Default.php')) {
                $options[] = array(
                    'value' => $parser,
                    'label' => $parser
                );
            }
        }

        return $options;
    }

}