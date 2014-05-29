<?php

class DataExchange_Iris_Model_Parser_Product_Mode {

    const CONFIGURABLE_AND_SIMPLE = 0;
    const ONLY_SIMPLE = 1;

    public function toOptionArray() {

        return array(
            array(
                'value' => self::CONFIGURABLE_AND_SIMPLE,
                'label' => Mage::helper('iris')->__('Configurable and Simple')
            ),
            array(
                'value' => self::ONLY_SIMPLE,
                'label' => Mage::helper('iris')->__('Only Simple')
            )
        );
    }

}