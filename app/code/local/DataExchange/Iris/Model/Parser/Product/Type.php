<?php

class DataExchange_Iris_Model_Parser_Product_Type {

    const SINGLE_FILE = 0;
    const DIRECTORY_FILES = 1;

    public function toOptionArray() {

        return array(
            array(
                'value' => self::SINGLE_FILE,
                'label' => Mage::helper('iris')->__('Single file')
            ),
            array(
                'value' => self::DIRECTORY_FILES,
                'label' => Mage::helper('iris')->__('Directory files')
            )
        );
    }

}